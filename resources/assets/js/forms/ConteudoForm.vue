<template>
  <div class="row">
    <form v-on:submit.prevent="send($event)">
      <div class="panel panel-default col-md-7">
        <div class="panel-heading">
          <h2> Adicionar conteúdo digital</h2>
        </div>
        <div class="panel-body">
                    
          <!-- TITULO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.title && errors.title.length > 0 }">
              <label for="titulo">Título:*</label>
              <input type="text"
                      class="form-control"
                      name="title"
                      id="titulo"
                      aria-describedby="titulo"
                      v-model.trim="form.title">
              <small id="titulo" class="text-info">Adicione o nome original da mídia.</small><br>
              
              <erros></erros>
          </div>
          <!-- TIPO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.tipo && errors.tipo.length > 0 }">
              <label for="tipoconteudo">Tipo de Conteúdo:*</label>
              <select class="form-control form-control-lg" name="tipo" id="tipoconteudo" v-model="form.tipo">
                  <option value="">« SELECIONE »</option>
                  <option v-for="(tipo, i) in tipos"
                          v-bind:value="tipo.id"
                          v-bind:key="i">{{tipo.name}}
                  </option>
              </select>
              <small class="text-info">Escolha a opção mais adequada à mídia que deseja publicar, conforme tipos disponíveis.</small><br>
              <erros :errors="errors.tipo"></erros>
              </div>
          </div>
                    
          <!-- CAMPO URL-->
          <div class="form-group" v-if="isTipoSite">
              <label for="url">URL:</label>
              <input type="text"
                      class="form-control"
                      name="url"
                      id="url">
              
          </div>
          <!-- CATEGORIA OPCIONAL-->
          <div class="form-group" v-if="categories.length != 0">
              <label for="estado">Categoria de Conteúdo:*</label>
              <select class="form-control form-control-lg" name="category" id="categoria" v-model="form.category">
                  <option value="">« SELECIONE »</option>
                  <option v-for="(item, i) in categories"
                          v-bind:value="item.name"
                          v-bind:key="i">{{item.name}}
                  </option>
              </select>
              <erros :errors="errors.categories"></erros>
          </div>
                    
          <!-- DESCRICAO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.description && errors.description.length > 0 }">
              <label for="descricao">Descrição:*</label>
              <editor v-model="form.description" 
                      id="descricao"
                      name="description" 
                      height="500px" 
                      mode="wysiwyg"/>
              <small class="text-info">Descreva á mídia de forma <b>resumida</b> e <b>objetiva</b>.
                  Esta é a primeira apresentação da mídia e pode ser o diferencial na hora do usuário escolher se acessa ou não. 
                  Verifique outras descrições para adotar o modelo mais adequado.
              </small><br>
              <erros :errors="errors.description"></erros>
          </div>
                    
          <!-- AUTORES -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.authors && errors.authors.length > 0 }">
              <label for="autores">Autores:*</label>
              <input type="text" class="form-control" name="authors" id="autores" v-model="form.authors">
              <small class="text-info">Nome dos autores ou grupo de trabalho responsável pelo desenvolvimento da mídia.</small><br>
              <erros :errors="errors.authors"></erros>
          </div>
          <!-- FONTE -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.source && errors.source.length > 0 }">
              <label for="fonte">Fonte:*</label>
              <input type="text" class="form-control" name="source" id="fonte" v-model="form.source" >
              <small class="text-info">Indique o site ou o nome da instituição que produziu a mídia.</small><br>
              <erros :errors="errors.source"></erros>
          </div>
          <!-- LICENCA -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.license && errors.license.length > 0 }">
              <label for="licenca-conteudo">Licença de Conteúdo:*</label>
              <select class="form-control form-control-lg"  name="license" id="licenca-conteudo" v-model="form.license">
                  <option value="" >« SELECIONE »</option>
                  <!--option v-for="(license, i) in licenses"
                          v-bind:value="license.id"
                          v-bind:key="i">
                          {{license.name}}
                  </option>
                  <optgroup  v-if="license.childs != null" >
                      <option v-for="(child, i) in childs"
                          v-bind:value="child.id"
                          v-bind:key="i">{{child.name}}>
                      </option>
                  </optgroup-->
              </select>
              <small class="text-info">
                  Escolha a opção que mais adequada à mídia que deseja publicar, conforme opções disponíveis. 
                  Se precisar de ajuda clique aqui
              </small><br>
              <erros :errors="errors.license"></erros>
          </div>
                      
                    <!--<div class="form-group" v-bind:class="{ 'has-error': errors.image && errors.image.length > 0 }">
                        <img class="img-responsive" width="150" height="150" v-if="image" :src="image">
                        <label for="image">Arquivo:</label>
                        <input type="file" class="form-control" id="image" name="image"
                                aria-describedby="image"
                                v-on:change="onFileChange($event)">
                        <small class="text-danger"
                                v-if="errors.image"
                                v-for="(error,f) in errors.image"
                                v-bind:key="f"
                                v-text="error">
                        </small>
                        <small v-if="this.file">
                            {{ ` ${this.file.name} -- ${this.file.size} -- ${this.file.type} `}}
                        </small>
                </div>-->
        <!-- CONDIÇÕES DE USO -->
        <div class="checkbox" v-bind:class="{ 'has-error': errors.terms && errors.terms.length > 0 }">
            <label for="termosecondicoes">
                <input id="termosecondicoes" name="terms" type="checkbox" v-model="form.terms"> Li e concordo com os termos e condições de uso.
            </label><br>
            <erros :errors="errors.terms"></erros>
        </div>
        <div class="form-group">
        <!--multiselect class="form-control" v-model="tipo" :options="tipos" placeholder="Tipo de conteúdo"></multiselect-->
        </div>
        <!-- APROVAR CONTEÚDO -->
        <div class="checkbox" v-bind:class="{ 'has-error': errors.is_approved && errors.is_approved.length > 0 }">
            <label for="aprovado">
                <input id="aprovado" name="is_approved" type="checkbox" v-model="form.is_approved"> Deseja publicar o conteúdo?
            </label><br>
            <erros :errors="errors.is_approved"></erros>
        </div>
      
                
        <!-- BOTÃO DE ENVIO -->
        <div class="form-group">
            <button class="btn btn-default">Salvar</button>
        </div>
        <!-- RESPOSTA FORMULARIO -->
        <alert></alert>

      </div>

      <!-- COMPONENTES E NIVEIS DE ENSINO -->
      <div class="panel panel-default col-md-5" v-if="categories.length != 0">
          <div class="panel-heading">
              Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:
          </div>
          <div class="panel-body">
              

          </div>
      </div>

      </form>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { client } from "../client.js";
import { response, goTo } from "../response.js";
import showErrors from "../components/ShowErrors.vue";
import Alert from "../components/AlertComponent.vue";
import "tui-editor/dist/tui-editor.css";
import "tui-editor/dist/tui-editor-contents.css";
import "codemirror/lib/codemirror.css";
import { Editor } from "@toast-ui/vue-editor";
import store from "../store";

export default {
  name: "ConteudoForm",
  components: {
    erros: showErrors,
    editor: Editor,
    alert: Alert
  },
  data() {
    return {
      form: {
        title: "",
        description: "",
        tipo: "",
        authors: "",
        source: "",
        license: "",
        image: "",
        terms: false,
        tags: [],
        canal: "",
        category: "",
        is_approved: false
      },

      licenses: [],

      options: {},

      tipos: [],

      is_featured: false,
      is_site: false,
      is_approved: false,
      autocompleteItems: [],
      category: "",

      categories: [],

      isUpdate: false,
      errors: {
        title: [],
        description: [],
        tipo: [],
        authors: [],
        source: [],
        license: [],
        terms: [],
        is_approved: []
      }
    };
  },
  created() {
    //his.getTipos();
    //this.getLicenses();
    if (this.$route.params.update) {
      //this.getConteudo();
      this.isUpdate = true;
      this.textButton = "Editar";
    }
  },
  computed: {
    isTipoSite() {
      return this.tipo == 8 ? true : false;
    }
  },
  methods: {
    send(event) {
      this.$store.dispatch("serializeFormData", event.target);
      const data = this.$store.getters.getFormData;
      this.$store.dispatch("createConteudo", data);
      console.log(this.$store.getters.getErrors);
    }
    /*
    async createConteudo() {
      let form = new FormData();
      form.append("title", this.title);
      form.append("tipo", this.tipo);
      form.append("description", this.description);
      form.append("url", this.options);
      form.append("canal_id", localStorage.canal_id);
      form.append("tags", this.tags);
      form.append("category_id", this.category_id);
      form.append("authors", this.authors);
      form.append("source", this.source);
      form.append("license", this.license);
      form.append("is_featured", this.is_featured);
      form.append("options", JSON.stringify(this.options));

      let resp = await client.post("/conteudos", form);

      if (response(resp)) {
        console.log("editado");
        goTo("Listar", this.$route.params.slug);
      } else {
        this.isError = resp.data.success;
        this.message = resp.data.message;
        this.errors = resp.data.errors;

        console.log(store.state.message);

        console.log();
      }
    },
    async getTipos() {
      let resp = await client.get("/tipos/conteudos");
      this.tipos = resp.data.tipos;
    },
    async getLicenses() {
      let resp = await client.get("/licenses");
      this.licenses = resp.data.paginator.data;
    },
    async getConteudo() {
      let resp = await client.get(`/conteudos/${this.$route.params.id}`);
      console.warn(resp);
      if (resp.data.success) {
        this.title = resp.data.conteudo.title;
        this.description = resp.data.conteudo.description;
        this.authors = resp.data.conteudo.authors;
        this.source = resp.data.conteudo.source;
        this.category = resp.data.conteudo.category_id;
        this.is_featured = resp.data.conteudo.is_featured;
      }
    },
    async editConteudo() {
      //console.log(params)
      let params = {
        name: this.name,
        description: this.description,
        canal: localStorage.idCanal,
        category: this.category
      };
      let resp = await client.put(`/conteudo/${this.$route.params.id}`, params);
    }
    */
  }
};
</script>
<style lang="scss" scoped>
/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4caf50;
}
</style>
