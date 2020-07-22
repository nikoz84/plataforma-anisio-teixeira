<template>
  <div class="q-pa-md row justify-center q-gutter-xs">
    <q-card class="col-sm-5">
      <q-card-section class="q-gutter-sm">
        <!-- CANAL --> 
        <q-select
          outlined
          option-value="id"
          option-label="name"
          ransition-show="scale"
          transition-hide="scale"
          v-model="conteudo.canal"
          :options="canais"
          label="Escolha um Canal"
          behavior="dialog"
          @input="getCategories"
          bottom-slots
          :error="errors.canal_id && errors.canal_id.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.canal_id"></ShowErrors>
          </template>
        </q-select>
        {{   }}
        <!-- CATEGORIA -->
        <ParentAndChildSelect :parent="categories" 
          :label="categoryName"
          :selectedId="conteudo.category_id"
          @click="setCategory"
        ></ParentAndChildSelect>
        <!--ShowErrors v-if="errors.category_id && errors.category_id.length > 0" 
            :errors="errors.category_id"></ShowErrors-->
        <!-- LICENÇAS -->
        <ParentAndChildSelect :parent="licencas" 
          label="Licença"
          :selectedId="conteudo.license_id"
          @click="setLicense"
        ></ParentAndChildSelect>
        <!--ShowErrors v-if="errors.license_id && errors.license_id.length > 0" 
          :errors="errors.license_id"></ShowErrors-->
          
        <!-- TIPO DE MIDIA --> 
        <q-select
          outlined
          stack-label
          option-value="id"
          option-label="name"
          transition-show="flip-up"
          transition-hide="flip-down"
          :error="errors.tipo_id && errors.tipo_id.length > 0"
          v-model="conteudo.tipo"
          :options="tipos"
          label="Tipo de Mídia"
          behavior="dialog"
        />
        <!-- TITULO --> 
        <q-input outlined v-model="conteudo.title" 
           label="Título do conteúdo"
           bottom-slots
          :error="errors.title && errors.title.length > 0"
           >
           <template v-slot:error>
            <ShowErrors :errors="errors.title"></ShowErrors>
          </template>
        </q-input>
        <!-- AUTORES --> 
        <q-input outlined v-model="conteudo.authors" 
          label="Autores"
          bottom-slots
          :error="errors.authors && errors.authors.length > 0">
           <template v-slot:error>
            <ShowErrors :errors="errors.authors"></ShowErrors>
          </template>
        </q-input>
        <!-- FONTE --> 
        <q-input outlined v-model="conteudo.source" 
          label="Fonte" 
          bottom-slots
          :error="errors.source && errors.source.length > 0">
           <template v-slot:error>
            <ShowErrors :errors="errors.source"></ShowErrors>
          </template>
        </q-input>
        <!-- DESCRIÇÃO --> 
        <div class="q-mt-md">
          <p class="text-center">Escreva uma descrição do conteúdo</p>
        </div>
        <q-editor v-model="conteudo.description" min-height="15rem" />
        <ShowErrors 
          :error="errors.description && errors.description.length > 0" 
          :errors="errors.description">
        </ShowErrors>
      </q-card-section>
      <q-card-section>
        <!-- TAGS --> 
        <q-select
          outlined
          v-model="conteudo.tags"
          use-input
          multiple
          option-value="id"
          option-label="name"
          hint="Palavras chave"
          use-chips
          stack-label
          input-debounce="300"
          new-value-mode="add-unique"
          @new-value="addTag"
          :options="autocompleteTags"
          @filter="getTags"
          bottom-slots
          :error="errors.tags && errors.tags.length > 0"
          >
           <template v-slot:error>
            <ShowErrors :errors="errors.tags"></ShowErrors>
          </template>
        </q-select>
      </q-card-section>
      <q-card-section>
        <q-img 
          loading="lazy" 
          width="100%" 
          height="200" 
          :src="conteudo.image"
          placeholder-src="/img/fundo-padrao.svg"
          alt="imagem de destaque"/>
          <!-- IMAGEM DE DESTAQUE --> 
          <ShowErrors :errors="errors.imagem_associada"></ShowErrors>
        <q-input
          @input="val => { file = val[0];}"
          outlined
          
          @change="onImageFileChange"
          type="file"
          hint="Imagem de Destaque"
        />
        <!-- ARQUIVO DE UPLOAD --> 
        <br>
        <q-item-label >
          Baixar Arquivo Download:
        </q-item-label>
         <a v-if="conteudo.download" :href="conteudo.download" :download="conteudo.download" >{{conteudo.download.split('/').pop()}}</a>
        <ShowErrors :errors="errors.download"></ShowErrors>
        <q-input
          class="q-mt-md"
          @input="val => {file = val[0];}"
          outlined
          @change="onDownloadFileChange"
          type="file"
          hint="Arquivo para Download"
        />
        
        
        <!-- ENVIAR SITE --> 
        <ShowErrors :errors="errors.options_site"></ShowErrors>
        <q-input
          outlined
          
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
        />
      </q-card-section>
      <q-card-section>
        <!-- CONTEUDO APROVADO --> 
        <div class="q-gutter-sm">
          <q-checkbox
            v-model="conteudo.is_approved"
            label="Aprovar conteúdo"
            color="pink"
          />
          <!-- MARCAR COMO DESTAQUE --> 
          <q-checkbox
            v-model="conteudo.is_featured"
            label="Marcar como destaque"
            color="pink"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <!-- TERMOS DE USO --> 
        <div class="q-gutter-sm">
          
          <q-item-label>
            Li e concordo com os <a href="#terms">termos e condições de uso</a> :
          
          <q-checkbox
            v-model="conteudo.terms"
           
            color="pink"
          />
          </q-item-label>
        </div>
      </q-card-section>
      <q-card-section>
        <!-- SALVAR --> 
        <q-btn
          class="full-width"
          color="primary"
          @click="save()"
          label="Salvar"
        ></q-btn>
      </q-card-section>
    </q-card>

    <q-card class="col-sm-3">
      
      <q-scroll-area
        style="height: 100vh;" visible
      >
        <q-card-section>
          <!-- COMPONENTES CURRICULARES --> 
          <div v-if="componentes">
            
            <div
              v-for="(component, i) in componentes"
              :key="`c-${i}`"
              :index="component.id"
            >
            
              
              <div class="text-center text-negative q-pt-md" >
                {{ component.name }}
              
              </div>
              <q-separator class="q-mt-lg" inset color="negative"></q-separator>
              <q-list
                dense bordered 
              >
                <q-item tag="label" 
                  v-ripple v-for="(component, i) in component.componentes"
                  :key="`child-com-${i}`">
                  <q-item-section avatar>
                    <q-checkbox
                      
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="negative"
                    />
                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{component.name}}
                  </q-item-label>
                </q-item>
              </q-list>
              <q-separator class="q-mt-lg" inset color="negative"></q-separator>
            </div>
          </div>
          
        </q-card-section>
      </q-scroll-area>
      <q-card-section>
        <ShowErrors 
        :error="errors.componentes && errors.componentes.length > 0" 
        :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      
    </q-card>
    <q-card class="col-sm-3">
      <q-scroll-area
        style="height: 100vh;" visible
      >
        <q-card-section>
          <!-- NIVEIS DE ENSINO --> 
          <div v-if="niveis">
            <div
              v-for="(nivel, n) in niveis"
              :key="`n-${n}`"
              :index="nivel.id"
            >
              <div class="text-center text-positive q-pt-md">
                {{ nivel.name }}
              </div>
              <q-separator class="q-mt-lg" inset color="positive"></q-separator>
              <q-list dense bordered>
                <q-item tag="label" 
                  v-ripple v-for="(component, i) in nivel.componentes"
                  :key="`child-com-${i}`">
                  <q-item-section avatar>
                    <q-checkbox
                      v-model="componentesCurriculares"
                      :val="component.id"
                      color="teal"
                    />
                  </q-item-section>
                  <q-item-label class="q-pt-sm">
                    {{component.name}}
                  </q-item-label>
                </q-item>
              </q-list>
              <q-separator class="q-mt-lg" inset color="positive"></q-separator>
            </div>
          </div>
        </q-card-section>
      </q-scroll-area>
      <q-card-section>
        <ShowErrors 
        :error="errors.componentes && errors.componentes.length > 0" 
        :errors="errors.componentes"></ShowErrors>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { ShowErrors, ParentAndChildSelect } from "@forms/shared";
import {
  QInput,
  QEditor,
  QCard,
  QCardSection,
  QSelect,
  QStepper,
  QStep,
  QStepperNavigation,
  QDialog,
  ClosePopup
} from "quasar";

export default {
  name: "ConteudoForm",
  directives: {
    ClosePopup
  },
  components: {
    QInput,
    QEditor,
    QCard,
    QSelect,
    QCardSection,
    QStepper,
    QStep,
    QStepperNavigation,
    ShowErrors,
    QDialog,
    ParentAndChildSelect
  },
  data() {
    return {
      step: 1,
      conteudo: {
        download:"",
        license_id: null,
        canal_id: null,
        category_id: null,
        tipo_id: null,
        site: "",
        title: "",
        description: "",
        canal: null,
        options: {
          site: ""
        },
        category:null,
        authors: "",
        source: "",
        image: "",
        tags: [],
        componentes: [],
        terms: false,
        is_approved: false,
        is_featured: false,
        is_site: false
      },
      categoriesList: [],
      canais: [],
      tipos: [],
      componentesCurriculares: [],
      licencas: [],
      autocompleteTags: [],
      categoryName: null,
      selectedCategory: '',
      categories: [],
      imagem_associada:null,
      download_file:null,
      errors:{},
      dialog: {
        text: "",
        open: false,
        confirm: false,
        new_tag: ""
      }
    };
  },
  mounted() {
    this.getData();
    this.getCategoriesList();
    this.getCategories(this.conteudo.canal);
  },
  computed: {
    ...mapState(["componentes", "niveis"])
  },
  methods: {
     async getCategoriesList() {
      let resp = await axios.get("/aplicativos/categories");
      if (resp.data.success) {
        this.categoriesList = resp.data.metadata;
      }
    },
    
    onImageFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.imagem_associada = files[0];
        },
    onDownloadFileChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
            return;
        this.download_file = files[0];
    },
    async save() {
      
      const form = new FormData();
      form.append(
        "license_id",
        this.conteudo.license ? this.conteudo.license.id : null
      );
      form.append("tipo_id", this.conteudo.tipo ? this.conteudo.tipo.id : null);
      form.append(
        "canal_id",
        this.conteudo.canal ? this.conteudo.canal.id : null
      );
      if(this.conteudo.category)
      form.append("category_id",  this.conteudo.category.id );
      form.append("title", this.conteudo.title);
      form.append("description", this.conteudo.description);
      form.append("source", this.conteudo.source);
      form.append("authors", this.conteudo.authors);
      if(this.conteudo.options.site)
      {
        console.log(this.conteudo.options.site)
          form.append("options_site", JSON.stringify(this.conteudo.options.site));
          form.append("is_site", true) ;
      }
      else
      {
        form.append("is_site", false);
      }
      console.log(this.conteudo)
      form.append("tipo_id", this.conteudo.tipo ? this.conteudo.tipo.id : "");
      form.append("canal_id", this.conteudo.canal ? this.conteudo.canal.id : "");
      
      form.append("license_id", this.conteudo.license_id ? this.conteudo.license_id : "");
      form.append("category_id",  this.conteudo.category_id ? this.conteudo.category_id : "" );
      form.append("title", this.conteudo.title ? this.conteudo.title : "");
      form.append("description", this.conteudo.description ? this.conteudo.description : "");
      form.append("source", this.conteudo.source ? this.conteudo.source : "");
      form.append("authors", this.conteudo.authors ? this.conteudo.authors : "");
      if (this.conteudo.tags.length) {
        let tags = this.conteudo.tags.map(item => item.id);
        for (var i = 0; i < tags.length; i++) {
          form.append("tags[]", tags[i]);
        }
      }
      form.append("componentes", this.componentesCurriculares);
      if(this.conteudo.terms)
      form.append("terms", this.conteudo.terms);
      form.append("is_approved", this.conteudo.is_approved ? true : false);
      form.append("is_featured", this.conteudo.is_featured ? true : false);
      if(this.imagem_associada)
      form.append("imagem_associada", this.imagem_associada );
      if(this.download_file)
      form.append("download", this.download_file );
      let url = "/conteudos";
      if (this.$route.params.action == "editar") {
        form.append("id", this.conteudo.id);
        form.append("_method", "PUT");
        url = url + '/' + this.conteudo.id; 
      }
      try{
        let { data } = await axios.post(url, form);
        console.log('ok',data)
        this.$router.push(`/admin/conteudos/listar`);
      }
      catch(ex)
      {
        console.log('err',ex)
        this.errors = ex.errors;
      }
    },
    async getCategories(val) {
      if(!val || !val.id)
      {
        return;
      }
      const id = val.id;
      this.conteudo.canal = val;
      const { data } = await axios.get(`/categorias/canal/${id}`);
      
      this.categories = data.metadata.categories;
      this.categoryName = data.metadata.category_name;
      
    },
    async getData() {
      const canais = axios.get("/canais?select");
      const tipos = axios.get("/tipos?select");
      const licencas = axios.get("/licencas?select");
      let responses = await axios.all([canais, tipos, licencas]);

      this.canais = responses[0].data.metadata;
      this.tipos = responses[1].data.metadata;
      this.licencas = responses[2].data.metadata;
      
      if (this.$route.params.id) {
        let { data } = await axios.get("/conteudos/" + this.$route.params.id);
        this.conteudo = data.metadata;
        console.log(this.conteudo)
        this.componentesCurriculares = data.metadata.componentes.map(a => a.id);
      }

      if(this.conteudo.category && this.conteudo.canal){
        this.getCategories(this.conteudo.canal);
        const category = this.conteudo.category
        this.selectedCategory = category.name;
      }
    },
    setCategory(id){
      this.conteudo.category_id = id
    },
    setLicense(id){
      this.conteudo.license_id = id
    },
    addTag(val, done) {
      const form = new FormData();
      const http = axios;

      if (this.autocompleteTags.length == 0) {
        this.showTagModal(val);
      }
    },
    showTagModal(val){
      this.$q.notify({
          message: `Essa palavra chave não existe deseja adicionar ${val}?`,
          multiLine: true,
          color: "grey-4",
          textColor: "primary",
          possition: "center",
          timeout: Math.random() * 5000 + 5000,
          actions: [
            {
              label: "Confirmar",
              color: "positive",
              handler: async () => {
                form.append("name", val);
                let { data } = await http.post("/tags", form);
                if (data.success) {
                  let id = data.metadata.id;
                  let label = data.metadata.name;
                  done({ id, label });
                }
              }
            },
            {
              label: "Cancelar",
              color: "secondary",
              handler: () => {
                //this.tags = this.tags.pop(0,);
              }
            }
          ]
        });
    },
    getTags(val, update, abort) {
      update(() => {
        if (val === "" && val.length < 3) {
          this.autocompleteTags = [];
        } else {
          const self = this;
          axios.get(`tags/autocomplete/${val}`).then(resp => {
            self.autocompleteTags = resp.data.metadata;
          });
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped></style>
