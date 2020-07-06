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
              :options="optsFormatos">
            </q-select>
          </q-card-section>
          <q-card-section>
              <q-item-label style="margin-bottom:10px" ><q-icon name="image" style="padding-bottom: 3px;" /><strong>Imagem Associada</strong></q-item-label>
              <q-img 
              loading="lazy" 
              style="height:150px; width:150px"
              :src="tipo.icon"
              placeholder-src="/img/fundo-padrao.svg"
              alt=" Icone da categoria :"/>
              <q-input
              @input="val => { file = val[0];}"
              outlined
              bottom-slots 
              :error="errors.imagemAssociada && errors.imagemAssociada.length > 0"
              @change="onFileChange"
              accept=".png, .webp, .svg, .jpeg, .jpg"
              type="file"
              hint="Imagem de Destaque"
              />
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
      tipo :{
        name: null,
        imagemAssociada:null,
        formatos : [],
        icon: null,
        options: {
          formator:[]
        }
      },
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
    onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            console.log("file:", files);
            this.tipo.imagemAssociada = files[0];
    },
    async getTipo(){
      if (!this.$route.params.id) return; 
      
      const { data } = await axios.get(`/tipos/${this.$route.params.id}`);
      this.tipo = data.metadata;
      console.log(this.tipo)
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
      form.append('formatos', this.tipo.formatos);
      
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

