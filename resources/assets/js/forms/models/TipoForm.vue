<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <q-card-section>
            <q-input label="Nome" 
              v-model="name"
              bottom-slots
              :error="errors.name && errors.name.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.name"></ShowErrors>
              </template>
            </q-input>
            <q-select label="Extensões" v-model="formatos" 
              use-chips
              multiple 
              :options="optsFormatos">
            </q-select>
          </q-card-section>
          <q-card-section>
            <q-img style="height: 150px; max-width: 150px" :src="icon"></q-img>
          </q-card-section>
          <q-card-section>
            {{ errors }}
          </q-card-section>
          <q-card-section>
            <q-btn @click.prevent="save()" class="full-width q-mt-md" label="Salvar" type="submit" color="primary"/>
          </q-card-section>
        </q-card>
    </div>
  </article>
</template>
<script>
import { ShowErrors } from "@forms/shared";

export default {
  name: "TipoForm",
  components: {
    ShowErrors
  },
  data() {
    return { 
      name: null,
      formatos : [],
      icon: null,
      optsFormatos: [
        'ppt','pps','odp','link','pdf','epub','doc','docx','odt','zip',
        'rar','mp4','mp3','webm','xls','xml','ods','csv','jpg','jpeg','png','gif','txt'
      ],
      errors: {}
    }
  },
  mounted() {
    this.getTipo()
  },
  methods: {
    async getTipo(){
      if (!this.$route.params.id) return; 
      
      const { data } = await axios.get(`/tipos/${this.$route.params.id}`);
      let tipo = data.metadata;
      this.name = tipo.name;
      this.formatos = tipo.options.formatos;
      this.icon = tipo.icon;
    },
    async save(){
      const url = this.$route.params.id ? `/tipos/${this.$route.params.id}` : '/tipos';
      const method = this.$route.params.id ? 'PUT' : 'POST';
      
      const form = new FormData();
      
      if (this.$route.params.action === "editar") {
        form.append("id", this.$route.params.id);
        form.append("_method", "PUT");
      }
      form.append('name', this.name);
      form.append('formatos', this.formatos);
      
      await axios({ method, url }, form).then(
        resp => {
          console.log(resp)
        }
      ).catch(e => {
        this.errors = e.errors
      });
    }

  }

};
</script>

