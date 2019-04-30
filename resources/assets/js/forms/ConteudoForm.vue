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
              <label for="titulo">Título:<span class="glyphicon-asterisk"></span></label>
              <input type="text"
                      class="form-control"
                      name="title"
                      id="titulo"
                      aria-describedby="titulo"
                      :value="conteudo.title">
              <small id="titulo" class="text-info">Adicione o nome original da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.title"></erros>
          </div>
          <!-- TIPO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.tipo && errors.tipo.length > 0 }">
              <label for="tipoconteudo">Tipo de Conteúdo:<span class="glyphicon-asterisk"></span></label>
              <select class="form-control form-control-lg" name="tipo" id="tipoconteudo" :value="conteudo.tipo">
                  <option value="">« SELECIONE »</option>
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
          <div class="form-group" v-if="isTipoSite">
              <label for="url">URL:</label>
              <input type="text"
                      class="form-control"
                      name="url"
                      id="url">
              
          </div>
          <!-- CATEGORIA OPCIONAL-->
          <div class="form-group" v-if="categories.length != 0">
              <label for="estado">Categoria de Conteúdo:<span class="glyphicon-asterisk"></span></label>
              <select class="form-control form-control-lg" name="category" id="categoria" :value="conteudo.category">
                  <option value="">« SELECIONE »</option>
                  <option v-for="(item, i) in categories"
                          v-bind:value="item.name"
                          v-bind:key="i">{{item.name}}
                  </option>
              </select>
              <!-- ERRORS -->
              <erros :errors="errors.categories"></erros>
          </div>
                    
          <!-- DESCRICAO -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.description && errors.description.length > 0 }">
              <label for="descricao">Descrição:<span class="glyphicon-asterisk"></span></label>
              <editor :value="conteudo.description" 
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
              <label for="autores">Autores:<span class="glyphicon-asterisk"></span></label>
              <input type="text" class="form-control" name="authors" id="autores" :value="conteudo.authors">
              <small class="text-info">Nome dos autores ou grupo de trabalho responsável pelo desenvolvimento da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.authors"></erros>
          </div>
          <!-- FONTE -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.source && errors.source.length > 0 }">
              <label for="fonte">Fonte:<span class="glyphicon-asterisk"></span></label>
              <input type="text" class="form-control" name="source" id="fonte" :value="conteudo.source" >
              <small class="text-info">Indique o site ou o nome da instituição que produziu a mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.source"></erros>
          </div>
          <!-- LICENCA -->
          <div class="form-group" v-bind:class="{ 'has-error': errors.licenses && errors.licenses.length > 0 }">
              <label for="licenca-conteudo">Licença de Conteúdo:<span class="glyphicon-asterisk"></span></label>
              <select class="form-control form-control-lg"  name="license" id="licenca-conteudo" :value="conteudo.license">
                  <option value="" >« SELECIONE »</option>
                  <optgroup label="Creative Commonds">
                    <option v-for="(child,i) in childsLicenses" :key="i" >
                      {{child}}
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
            <label class="container" for="termosecondicoes">
                <input id="termosecondicoes" name="terms" type="checkbox" :value="conteudo.terms"><span class="container-text">Li e concordo com os termos e condições de uso.</span>
                <span class="checkmark"></span>
            </label><br>
            <!-- ERRORS -->
            <erros :errors="errors.terms"></erros>
        </div>
        <div class="form-group">
        <!--multiselect class="form-control" :value="tipo" :options="tipos" placeholder="Tipo de conteúdo"></multiselect-->
        </div>
        <!-- APROVAR CONTEÚDO -->
        <div class="checkbox" v-bind:class="{ 'has-error': errors.is_approved && errors.is_approved.length > 0 }">
            <label for="aprovado" class="container">
                <input id="aprovado" name="is_approved" type="checkbox" :value="conteudo.is_approved"> <span class="container-text">Deseja publicar o conteúdo?</span>
                <span class="checkmark"></span>
            </label><br>
            <!-- ERRORS -->
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
//import { response, goTo } from "../response.js";
import showErrors from "../components/ShowErrors.vue";
import Alert from "../components/AlertComponent.vue";
import "tui-editor/dist/tui-editor.css";
import "tui-editor/dist/tui-editor-contents.css";
import "codemirror/lib/codemirror.css";
import { Editor } from "@toast-ui/vue-editor";
import store from "../store";
import debounce from 'lodash/debounce';
import { timeout } from 'q';


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
  created() {
    this.$store.dispatch("getTipos");
    this.$store.dispatch("getLicenses");
    
    if (this.$route.params.update) {
      let payload = {
        slug: this.$route.params.slug,
        id: this.$route.params.id
      }
       
      this.$store.dispatch("getConteudo",payload);
      this.isUpdate = this.$route.params.update;
      this.textButton = "Editar";
    }else{
      this.$store.state.conteudo;
    }
  },
  computed: {
    id(id) {
      return id;
    },
    conteudo(){
      return this.$store.state.conteudo;
    },
    isTipoSite() {
      return this.tipo == 8 ? true : false;
    },
    errors() {
      return this.$store.state.errors;
    },
    licensesFilter() {
      const licenses = this.$store.state.licenses;
      return licenses.filter(function(item) {
        return item.id != 2;
      });
    },
    childsLicenses() {
      const items = this.$store.state.licenses;
      let a = items.filter(function(item) {
        if (item.id == 2) {
          return item;
        }
      });

      //let ret = a[0];
      //console.log(ret);
      //return ret;
    },
    tipos() {
      return this.$store.state.tipos;
    }
  },
  methods: {
    send(event) {
      if(this.$route.params.update){
        this.$store.dispatch("updateConteudo", this.$store.state.conteudo);
      }else{
        this.$store.dispatch("createConteudo", this.$store.state.conteudo);
      }

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
