<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <q-card-section>
            <q-input label="Nome" 
              v-model="tipo.name"
              bottom-slots
              :error="errors.name && errors.name.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.name"></ShowErrors>
              </template>
            </q-input>
            <q-select label="Extensões" v-model="tipo.options.formatos" 
              use-chips
              multiple 
              :options="extensions">
            </q-select>
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
      tipo: {
        name: null,
        options: {
          formatos : []
        }
      },
      extensions: [
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
    async getTipo() {
      if(!this.$route.params.id) return;

      let {data} = await axios.get(`/tipos/${this.$route.params.id}`);
      this.tipo = data.metadata;
    },
    async save(){
      const url = this.$route.params.id ? `/tipos/${this.$route.params.id}` : '/tipos';
      const method = this.$route.params.id ? 'PUT' : 'POST';
      let data = {
        name : this.tipo.name,
        options: this.options
      }
      await axios({
        method,
        url
        }, data).then(
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

