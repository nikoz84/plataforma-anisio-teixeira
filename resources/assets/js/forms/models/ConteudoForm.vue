<template>
  <div class="q-pa-md row justify-center q-gutter-xs">
    <q-card class="col-sm-5">
      <q-card-section class="q-gutter-sm">
        <q-input outlined v-model="conteudo.title" 
            label="Título do conteúdo"
            autogrow
            bottom-slots
            :error="errors && errors.title && errors.title.length > 0"
            >
            <template v-slot:error>
              <ShowErrors :errors="errors.title"></ShowErrors>
            </template>
          </q-input>
      </q-card-section>
      <q-card-section>
        <q-select
          outlined
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.tipo_id"
          :options="tipos"
          label="Tipo de Mídia"
          :error="errors && errors.tipo_id && errors.tipo_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.tipo_id"></ShowErrors>
          </template>
        </q-select>
      
      </q-card-section>
      <q-card-section class="q-gutter-sm">
        
      </q-card-section>
      
      <q-card-section class="q-gutter-sm">
        <q-select
          outlined
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.canal_id"
          :options="canais"
          label="Escolha um Canal"
          @input="getCategories"
          :error="errors && errors.canal_id && errors.canal_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.canal_id"></ShowErrors>
          </template>
        </q-select>
        
        <!-- CATEGORIA -->
        <ParentAndChildSelect :parent="categories" 
          :label="categoryName"
          :selectedId="conteudo.category_id"
          @click="setCategory"
        ></ParentAndChildSelect>
        <div class="q-my-md" v-if="errors && errors.category_id && errors.category_id.length > 0">
          <ShowErrors :errors="errors.category_id"></ShowErrors>
        </div>
        
        <!--q-select
          v-if="categories && categories.length > 0"
          outlined
          stack-label
          emit-value
          map-options
          option-value="id"
          option-label="name"
          v-model="conteudo.category_id"
          :options="categories"
          @input="setCategory"
          @getOptionLabel="getOptionLabel"
          options-selected-class="text-deep-orange"
          label="Escolha uma Categoria"
          :error="errors && errors.category_id && errors.category_id.length > 0"
          bottom-slots
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.category_id"></ShowErrors>
          </template>
        </!--q-select -->


        <!-- AUTORES -->
        <div class="q-my-lg">
          <q-input outlined v-model="conteudo.authors" 
            label="Autores"
            autogrow
            bottom-slots
            :error="errors && errors.authors && errors.authors.length > 0">
            <template v-slot:error>
              <ShowErrors :errors="errors.authors"></ShowErrors>
            </template>
          </q-input>
        </div>
        <!-- FONTE --> 
        <div class="q-my-lg">
          <q-input outlined v-model="conteudo.source" 
            label="Fonte"
            autogrow
            bottom-slots
            :error="errors && errors.source && errors.source.length > 0">
            <template v-slot:error>
              <ShowErrors :errors="errors.source"></ShowErrors>
            </template>
          </q-input>
        </div>
        
        </q-card-section>

        <q-card-section>
        
        <!-- LICENÇAS -->
        <ParentAndChildSelect :parent="licencas" 
          label="Licença"
          :selectedId="conteudo.license_id"
          @click="setLicense"
        ></ParentAndChildSelect>
        <div> {{license_description ? license_description : '' }} </div>
        <div class="q-my-md" v-if="errors && errors.license_id && errors.license_id.length > 0">
          <ShowErrors :errors="errors.license_id"></ShowErrors>
        </div>
        
        
        <!-- DESCRIÇÃO --> 
        <div class="q-mt-md">
          <p class="text-center">Escreva uma descrição 
            <b>(Para melhorar a qualidade de nossa oferta e busca de conteúdos 
            deve escrever um texto como mínimo de 140 caracteres)</b>
          </p>
        </div>
        <q-editor v-model="conteudo.description" min-height="18rem"
          ref="editor_ref"
          @paste.native="evt => pasteCapture(evt)"
          :toolbar="[['bold', 'italic', 'strike', 'underline']]"/>
        <ShowErrors v-if="errors && errors.description && errors.description.length > 0" 
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
          hint="Pesquise entre 3 a 10 palavras-chave para melhorar as buscas, se não achar a palavra escreva uma palavra e adicione apertando enter"
          use-chips
          stack-label
          hide-dropdown-icon
          label="Escreva aqui uma palavra para sugestões"
          input-debounce="200"
          new-value-mode="add-unique"
          @new-value="addTag"
          :options="autocompleteTags"
          @filter="getTags"
          bottom-slots
          :error="errors && errors.tags && errors.tags.length > 0"
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
        <q-input
          @input="val => { file = val[0];}"
          outlined
          accept=".png,.jpeg,.jpg,.svg,.webp"
          @change="onImageFileChange"
          type="file"
          hint="IMAGEM de destaque"
          bottom-slots
          :error="errors && errors.imagem_associada && errors.imagem_associada.length > 0"
          >
           <template v-slot:error>
            <ShowErrors :errors="errors.imagem_associada"></ShowErrors>
          </template>
        </q-input>
      </q-card-section>
        <!-- ARQUIVO DE DOWNLOAD --> 
      <q-card-section>
        <DeleteFiles message="Download"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['download'] : null"
          directory="download"
          >
        </DeleteFiles>
        <DeleteFiles message="Visualização"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['visualizacao'] : null"
          directory="visualizacao"
          >
        </DeleteFiles>
        <q-input
          class="q-mt-md"
          @input="val => {file = val[0];}"
          outlined
          @change="onDownloadFileChange"
          type="file"
          hint="Arquivo para Download"
          bottom-slots
          :error="errors && errors.download && errors.download.length > 0"
        >
          <template v-slot:error>
            <ShowErrors :errors="errors.download"></ShowErrors>
          </template>
        </q-input>
        <!-- ARQUIVO DE UPLOAD --> 
        <br>
        <DeleteFiles message="Guias Pedagógicos"
          :file="conteudo && conteudo.arquivos ? conteudo.arquivos['guias-pedagogicos'] : null"
          directory="guias-pedagogicos"
          >
        </DeleteFiles>
        
        <q-input
          class="q-mt-md"
          @input="val => {file = val[0];}"
          outlined
          @change="onguiaPedagogicoFileChange"
          type="file"
          hint="Arquivo para Guia Pedagógico"
           bottom-slots
          :error="errors && errors.guias_pedagogicos && errors.guias_pedagogicos.length > 0"
          >
           <template v-slot:error>
            <ShowErrors :errors="errors.guias_pedagogicos"></ShowErrors>
          </template>
        </q-input>
        <!-- ENVIAR SITE -->
        <br>
        <q-input
          outlined
          v-model="conteudo.options.site"
          label="URL do Site"
          hint="Exemplo: http://dominio.com.br"
          bottom-slots
          :error="errors && errors.options && errors.options.site && errors.options.site.length > 0"
          >
          <template v-slot:error>
            <ShowErrors :errors="errors.options.site"></ShowErrors>
          </template>
        </q-input>
        
        
      </q-card-section>
      <q-card-section>
        <div class="q-gutter-sm">
          <!-- CONTEUDO APROVADO --> 
          <q-checkbox
            v-model="conteudo.is_approved"
            label="Aprovar conteúdo"
            color="pink"
          />
          <div v-if="errors && errors.is_approved && errors.is_approved.length > 0">
            <ShowErrors :errors="errors.is_approved"></ShowErrors>
          </div>
          
          <!-- MARCAR COMO DESTAQUE --> 
          <q-checkbox
            v-model="conteudo.is_featured"
            label="Marcar como destaque"
            color="pink"
          />
          <div v-if="errors && errors.is_featured && errors.is_featured.length > 0">
            <ShowErrors :errors="errors.is_featured"></ShowErrors>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <!-- TERMOS DE USO --> 
        <div class="q-gutter-sm">
          Li e concordo com os <a href="#terms">termos e condições de uso</a> :
          <q-checkbox v-model="terms" color="pink" />
          <div v-if="errors && errors.terms && errors.terms.length > 0">
            <ShowErrors :errors="errors.terms"></ShowErrors>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <!-- SALVAR --> 
        <q-btn
          class="full-width"
          color="primary"
          @click="save()"
          label="Salvar"
          :loading="loading"
        ></q-btn>
      </q-card-section>
    </q-card>
    <q-card class="col-sm-3"  :class="{'error-card' : errors && errors.componentes && errors.componentes.length > 0 }">
      <q-card-section v-if="errors && errors.componentes && errors.componentes.length > 0">
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      <q-card-section>
          <!-- COMPONENTES CURRICULARES --> 
          <div v-if="componentes">
            <div v-for="component in componentes" :key="`c-${component.id}`">
              <div class="text-center text-negative q-pt-md" >
                {{ component.name }}
              </div>
              <q-separator class="q-mt-lg" inset color="negative"></q-separator>
              <q-list dense bordered>
                <q-item  v-ripple 
                v-for="(component, i) in component.componentes" :key="`child-com-${i}`">
                  <q-item-section avatar>
                    <q-checkbox v-model="componentesCurriculares" :val="component.id" color="negative"/>
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
      
      <q-card-section class="q-mt-lg" v-if="errors && errors.componentes && errors.componentes.length > 0">
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      
    </q-card>
    <q-card class="col-sm-3" :class="{'error-card' : errors && errors.componentes && errors.componentes.length > 0 }">
      <q-card-section class="q-mt-lg" v-if="errors && errors.componentes && errors.componentes.length > 0">
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
      <q-card-section>
          <!-- NIVEIS DE ENSINO --> 
          <div v-if="niveis">
            <div v-for="nivel in niveis" :key="`n-${nivel.id}`">
              <div class="text-center text-positive q-pt-md">
                {{ nivel.name }}
              </div>
              <q-separator class="q-mt-lg" inset color="positive"></q-separator>
              <q-list dense bordered>
                <q-item v-for="(component, i) in nivel.componentes" :key="`child-com-${i}`"
                  tag="label" v-ripple>
                  <q-item-section avatar>
                    <q-checkbox v-model="componentesCurriculares" :val="component.id" color="teal"/>
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
      
      <q-card-section class="q-mt-lg"  v-if="errors && errors.componentes && errors.componentes.length > 0">
        <ShowErrors :errors="errors.componentes"></ShowErrors>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>// @ts-nocheck

import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { ShowErrors, ParentAndChildSelect } from "@forms/shared";
import { PasteCapture } from "@mixins/RemoveFormat";
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
  ClosePopup,
  QCheckbox,
  QSeparator,
  QBtn,
  QList,
  QItem,
  QItemSection,
  QItemLabel
} from "quasar";
import DeleteFiles from "./DeleteFiles";

export default {
  name: "ConteudoForm",
  mixins: [PasteCapture],
  directives: {
    ClosePopup
  },
  components: {
    DeleteFiles,
    QInput,
    QItemSection,
    QCheckbox,
    QBtn,
    QList,
    QItem,
    QItemLabel,
    QSeparator,
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
        guiaPedagogico:"",
        license_id: "",
        canal_id: "",
        category_id: "",
        tipo_id: "",
        title: "",
        description: "",
        canal: "",
        options: {
          site: ""
        },
        category:"",
        authors: "",
        source: "",
        image: "",
        tags: [],
        componentes: [],
        is_approved: false,
        is_featured: false,
        is_site: false
      },
      categoriesList: [],
      canais: [],
      terms: false,
      tipos: [],
      componentesCurriculares: [],
      niveis: [],
      componentes: [],
      licencas: [],
      autocompleteTags: [],
      categoryName: null,
      selectedCategory: '',
      categories: [],
      imagem_associada:null,
      download_file:null,
      guias_pedagogicos: null,
      license_description: null,
      loading: false,
      errors: {},
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
  },
  computed: {
    //
  },
  methods: {
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
    onguiaPedagogicoFileChange(e){
       var files = e.target.files || e.dataTransfer.files;
       if (!files.length)
            return;
        this.guias_pedagogicos = files[0];
    },
    async save() {
      this.loading = true;
      const form = new FormData();
      
      form.append('conteudo', JSON.stringify({
          category_id: this.conteudo.category_id ? this.conteudo.category_id : null,
          title: this.conteudo.title,
          tipo_id: this.conteudo.tipo_id,
          canal_id: this.conteudo.canal_id,
          license_id: this.conteudo.license_id,
          title: this.conteudo.title,
          description: this.conteudo.description,
          source: this.conteudo.source,
          authors: this.conteudo.authors,
          componentes: this.componentesCurriculares,
          tags: this.conteudo.tags.map(item => item.id),
          terms: this.terms,
          is_featured: this.conteudo.is_featured,
          is_approved: this.conteudo.is_approved,
          is_site: this.conteudo.options.site == '' ? false : true,
          options: {
            site : this.conteudo.options.site
          }
        })
      );
      
      if(this.imagem_associada){
        form.append("imagem_associada", this.imagem_associada );
      }
      if(this.download_file){
        form.append("download", this.download_file);
      }
      if(this.guias_pedagogicos){
        form.append("guias_pedagogicos", this.guias_pedagogicos );
      }
      
      let url = "/conteudos";
      if (this.$route.params.id) {
        form.append("id", this.conteudo.id);
        form.append("_method", "PUT");
        url = url + '/' + this.conteudo.id; 
      }
      try {
        const { data } = await axios.post(url, form, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        });
        this.loading = false;
        if(data.success == true){
          this.$router.push(`/admin/conteudos/listar`);
        } 
        
      } catch(ex) {
        this.errors = ex.errors;
        this.loading = false;
      }
    },
    
    hasChild (scope) {
      return scope.opt.sub_categories.some(c => c.id === this.conteudo.category_id)
      //scope.opt.children.some(c => c.name === this.model)
    },
    
    async getCategories(val) {
      
      if(!val) return;
      const id = val.hasOwnProperty('id') ? val.id: val;
      this.$q.loading.show()
      try {
        const { data } = await axios.get(`/categorias/canal/${id}`);
        
          this.categories = data.metadata.categories;
          this.categoryName = data.metadata.category_name;
        this.$q.loading.hide()
      } catch (error) {
        this.$q.loading.hide()
      }
    },
    getSubCategorias(val){
      let subCat = null;
      if(!val) return;
      
      subCat = this.categories.filter((item)=>{
        return item.id == val
      })

      return subCat
      
    },
    async getData() {
      this.$q.loading.show();
      
      const canais = await axios.get("/canais?select");
      const tipos = await axios.get("/tipos?select");
      const licencas = await axios.get("/licencas?select");
      const niveis = await axios.get('/niveis-ensino?select');
      const componentes = await axios.get('/componentescategorias?select')
      this.canais = canais.data.metadata;
      this.tipos = tipos.data.metadata;
      this.licencas = licencas.data.metadata;
      this.niveis = niveis.data.metadata;
      this.componentes = componentes.data.metadata;
      //this.componentesCurriculares = componentes.data.metadata;
      
      if (this.$route.params.id) {
        let { data } = await axios.get("/conteudos/" + this.$route.params.id);
        this.conteudo = data.metadata;
        
        this.componentesCurriculares = data.metadata.componentes.map(a => a.id);
      }
      this.$q.loading.hide();
      if(this.conteudo.category && this.conteudo.canal){
        
        this.getCategories(this.conteudo.canal);
        const category = this.conteudo.category
        this.selectedCategory = category.name;
      }
    },
    setCategory(cat){
      console.log(cat)
      this.conteudo.category_id = cat.id
      return cat
      
    },
    getOptionLabel(ev){
      console.log(ev, 'sds')
    },
    setLicense(id){
      this.conteudo.license_id = id;
      axios.get(`/licencas/${id}`).then(resp => {
        this.license_description = resp.data.metadata.description;
      })
    },
    setCanal(id){
      this.conteudo.canal_id = id
      this.getCategories({id})
    },
    setTipo(id){
      this.conteudo.tipo_id = id
    },
    addTag(val, done) {
      //const form = new FormData();
      //const http = axios;
      console.log(val, this.autocompleteTags)
      if (this.autocompleteTags.length == 0) {
        this.showTagModal(val);
      }
    },
    showTagModal(val){
      this.$q.notify({
          message: `Essa palavra-chave não existe deseja adicionar ${val}?`,
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
                let tag = {name: val}
                
                let { data } = await axios.post("/tags", tag);
                
                if (data.success) {
                  let label = data.metadata.name;
                  //done({ id, label });
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
<style lang="stylus" scoped>
.error-card {
  border: solid 2px #a54a54;
}
</style>
