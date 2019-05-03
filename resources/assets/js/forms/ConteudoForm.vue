<template>
  <div class="row">
    <form v-on:submit.prevent="send($event)" >
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
                      name="titulo"
                      id="titulo"
                      aria-describedby="titulo"
                      v-model="title">
              <small id="titulo" class="text-info">Adicione o nome original da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.title"></erros>
          </div>
          <!-- TIPO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.tipo && errors.tipo.length > 0 }">
              <label for="tipoconteudo">Tipo de Conteúdo:*</label>
              <select class="form-control form-control-lg" name="tipo" id="tipoconteudo" v-model="tipo_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <option v-for="(tipo, i) in tipos"
                          v-bind:value="tipo.id"
                          v-bind:key="i">{{tipo.name}}
                  </option>
              </select>
              <small class="text-info">Escolha a opção mais adequada à mídia que deseja publicar, conforme tipos disponíveis.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.tipo"></erros>
              </div>
          </div>
                    
          <!-- CAMPO URL-->
          <!--div class="form-group" v-if="isTipoSite">
              <label for="url">URL:</label>
              <input type="text"
                      class="form-control"
                      name="url"
                      id="url">
              
          </div-->
          <!-- CATEGORIA OPCIONAL-->
          <div class="form-group" v-if="categories.length != 0">
              <label for="estado">Categoria de Conteúdo:*</label>
              <select class="form-control form-control-lg" name="category" id="categoria" v-model="category_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <option v-for="(item, i) in categories"
                          v-bind="item.name"
                          v-bind:key="i">{{item.name}}
                  </option>
              </select>
              <!-- ERRORS -->
              <erros :errors="errors.categories"></erros>
          </div>
                    
          <!-- DESCRICAO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.description && errors.description.length > 0 }">
              <label for="descricao">Descrição:*</label>
              <editor v-model="description" 
                      id="descricao"
                      name="description" 
                      height="500px" 
                      mode="wysiwyg"/>
              <small class="text-info">Descreva á mídia de forma <b>resumida</b> e <b>objetiva</b>.
                  Esta é a primeira apresentação da mídia e pode ser o diferencial na hora do usuário escolher se acessa ou não. 
                  Verifique outras descrições para adotar o modelo mais adequado.
              </small><br>
              <!-- ERRORS -->
              <erros :errors="errors.description"></erros>
          </div>
                    
          <!-- AUTORES -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.authors && errors.authors.length > 0 }">
              <label for="autores">Autores:*</label>
              <input type="text" class="form-control" name="authors" id="autores" v-model="authors">
              <small class="text-info">Nome dos autores ou grupo de trabalho responsável pelo desenvolvimento da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.authors"></erros>
          </div>
          <!-- FONTE -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.source && errors.source.length > 0 }">
              <label for="fonte">Fonte:*</label>
              <input type="text" class="form-control" name="source" id="fonte" v-model="source" >
              <small class="text-info">Indique o site ou o nome da instituição que produziu a mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.source"></erros>
          </div>
          <!-- LICENCA -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.licenses && errors.licenses.length > 0 }">
              <label for="licenca-conteudo">Licença de Conteúdo:*</label>
              <select class="form-control form-control-lg"  name="license" id="licenca-conteudo" v-model="license_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <optgroup v-if="childsLicenses" :label="childsLicenses.name">
                    <option v-for="(child, i) in childsLicenses.childs" :key="i" :value="child.id">
                      {{child.name}}
                    </option>
                  </optgroup>
                  <option v-for="(license, i) in licensesFilter" :key="i" :value="license.id">
                      {{license.name}}
                  </option>
                  
                  
              </select>    
                  
              <small class="text-info">
                  Escolha a opção que mais adequada à mídia que deseja publicar, conforme opções disponíveis. 
                  Se precisar de ajuda clique aqui
              </small><br>
              <!-- ERRORS -->
              <erros :errors="errors.licenses"></erros>
          </div>
          <!-- IMAGEM DE DESTAQUE -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.image && errors.image.length > 0 }">
            <label for="image">Imagem de destaque:</label>
            <input type="file" class="form-control" id="image" name="image"
                    aria-describedby="image">
            <erros :errors="errors.image"></erros>
          </div>
          <!-- CONDIÇÕES DE USO -->
          <div class="checkbox" v-bind:class="{ 'has-error': errors.terms && errors.terms.length > 0 }">
              <label for="termosecondicoes">
                  <input id="termosecondicoes" name="terms" type="checkbox" v-model="terms"> Li e concordo com os termos e condições de uso.
              </label><br>
              <!-- ERRORS -->
              <erros :errors="errors.terms"></erros>
          </div>
          <div class="form-group">
          <!--multiselect class="form-control" v-model="tipo" :options="tipos" placeholder="Tipo de conteúdo"></multiselect-->
          </div>
          <!-- APROVAR CONTEÚDO -->
          <div class="checkbox" v-bind:class="{ 'has-error': errors.is_approved && errors.is_approved.length > 0 }">
              <label for="aprovado">
                  <input id="aprovado" name="is_approved" type="checkbox" v-model="is_approved"> Deseja publicar o conteúdo?
              </label><br>
              <!-- ERRORS -->
              <erros :errors="errors.is_approved"></erros>
          </div>
          <!-- BOTAO DE ENVIO -->
          <div class="form-group">
            <button class="btn btn-default">Salvar</button>
          </div>
          <!-- RESPOSTA FORMULARIO -->
          <alert></alert>

        </div>

        <!-- COMPONENTES E NIVEIS DE ENSINO -->
        <div class="panel panel-default col-md-5">
            <div class="panel-heading">
                Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:
            </div>
            <div class="panel-body">
                {{$store.state.conteudo}}
            </div>
        </div>
      </form>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from "vuex";
import { mapFields } from 'vuex-map-fields';
import { client } from "../client.js";
//import { response, goTo } from "../response.js";
import showErrors from "../components/ShowErrors.vue";
import Alert from "../components/AlertComponent.vue";
import "tui-editor/dist/tui-editor.css";
import "tui-editor/dist/tui-editor-contents.css";
import "codemirror/lib/codemirror.css";
import { Editor } from "@toast-ui/vue-editor";
import debounce from "lodash/debounce";


export default {
  name: "ConteudoForm",
  components: {
    erros: showErrors,
    editor: Editor,
    alert: Alert
  },
  data() {
    return {
      autocompleteItems: [],
      categories: []
    };
  },
  mounted() {
    this.fetchTipos();
    this.fetchLicenses();
    this.fetchConteudos(this.$route.params);
  },
  computed: {
    ...mapState({ 
        errors: "errors",
        tipos : "tipos",
        isError: "isError" }),
    ...mapFields(
      { license_id: "conteudo.license_id",
        canal_id: "conteudo.canal_id",
        category_id: "conteudo.category_id",
        tipo_id: "conteudo.options.tipo.id",
        title: "conteudo.title",
        description: "conteudo.description",
        authors: "conteudo.authors",
        source: "conteudo.source",
        image: "conteudo.image",
        terms: "conteudo.terms",
        tags: "conteudo.tags",
        components: "conteudo.components",
        is_approved: "conteudo.is_approved",
        is_featured: "conteudo.is_featured",
        is_site: "conteudo.is_site"}
      ),
    licensesFilter() {
      const licenses = this.$store.state.licenses;
      if (licenses && licenses.length != 0) {
        return licenses.filter(function(item) {
          return item.id != 2 && !item.parent_id ? item : null;
        });
      }
    },
    childsLicenses() {
      const licenses = this.$store.state.licenses;
      if (licenses && licenses.length != 0) {
        let cCommonsChilds = {};
        licenses.forEach(element => {
          if (element.id == 2) {
            cCommonsChilds = element;
          }
        });
        return cCommonsChilds;
      }
    }
  },
  methods: {
    ...mapActions({
      fetchConteudos: "getConteudo",
      fetchTipos: "getTipos",
      fetchLicenses: "getLicenses",
      createConteudo: "createConteudo",
      updateConteudo: "updateConteudo"
    }),
    send() {
      
      if (this.$route.params.id) {
        this.updateConteudo(this.$store.state.conteudo);
        
      } else {
        this.createConteudo(this.$store.state.conteudo);
        
      }
      if(this.isError) return; 
      
        /*
      if(!this.isError){
        this.$router.push({ name:'ExibirConteudo', params: {slug: this.$route.params.slug, id: this.$store.state.conteudo.id}})
      }
      */
      setTimeout(() => {
        this.$store.commit("SET_SHOW_ALERT", false);
        this.$store.commit("SET_IS_ERROR", false);
      }, 2000);
    }
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
