<template>
  <div class="row">
    <form v-on:submit.prevent="send($event)" >
      <div class="panel panel-default col-md-7">
        <div class="panel-heading">
          <h2> Editar conteúdo digital</h2>
        </div>
        <div class="panel-body">
                    
          <!-- TITULO -->
          <div class="form-group" v-bind:class="showError('title')">
              <label for="titulo">Título:*</label>
              <input type="text"
                      class="form-control"
                      name="titulo"
                      id="titulo"
                      aria-describedby="titulo"
                      v-model.trim="title">
              <small id="titulo" class="text-info">Adicione o nome original da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.title"></erros>
          </div>
          <!-- TIPO -->
          <div class="form-group" v-bind:class="showError('tipo')">
              <label for="tipo-conteudo">Tipo de Conteúdo:*</label>
              <select class="form-control form-control-lg" name="tipo" id="tipo-conteudo" v-model="tipo_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <option v-for="(tipo, i) in tiposForm"
                          :value="tipo.id"
                          :key="i">{{tipo.name}}
                  </option>
              </select>
              <small class="text-info">Escolha a opção mais adequada à mídia que deseja publicar, conforme tipos disponíveis.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.tipo"></erros>
              
          </div>
          <!-- CANAL -->
          <div class="form-group" v-bind:class="showError('canal_id')">
              <label for="canal-id">Canal:*</label>
              <select class="form-control form-control-lg" name="tipo" id="canal-id" v-model="canal_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <option v-for="(canal, i) in canais"
                          v-bind:value="canal.id"
                          v-bind:key="i">{{canal.name}}
                  </option>
              </select>
              <small class="text-info">Escolha um Canal.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.canal_id"></erros>
          </div>
                    
          
          <div class="form-group" v-if="is_site">
              <label for="url">URL do site:</label>
              <input type="text"
                      class="form-control"
                      name="url"
                      v-model="site"
                      id="url">
              <small class="text-info">Adicione a URL ou link do site.</small><br>
          </div>
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
          <div class="form-group" v-bind:class="showError('description')">
              <label for="descricao">Descrição:*</label>
              <editor v-model.trim="description" 
                      id="description"
                      name="description"
                      :options="editorOptions"
                      mode="wysiwyg" 
                      />
              <small class="text-info">Descreva á mídia de forma <b>resumida</b> e <b>objetiva</b>.
                  Esta é a primeira apresentação da mídia e pode ser o diferencial na hora do usuário escolher se acessa ou não. 
                  Verifique outras descrições para adotar o modelo mais adequado.
              </small><br>
              <!-- ERRORS -->
              <erros :errors="errors.description"></erros>
          </div>
                    
          <!-- AUTORES -->
          <div class="form-group" v-bind:class="showError('authors')">
              <label for="autores">Autores:*</label>
              <input type="text" class="form-control" name="authors" id="autores" v-model.trim="authors">
              <small class="text-info">Nome dos autores ou grupo de trabalho responsável pelo desenvolvimento da mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.authors"></erros>
          </div>
          <!-- FONTE -->
          <div class="form-group" v-bind:class="showError('source')">
              <label for="fonte">Fonte:*</label>
              <input type="text" class="form-control" name="source" id="fonte" v-model.trim="source" >
              <small class="text-info">Indique o site ou o nome da instituição que produziu a mídia.</small><br>
              <!-- ERRORS -->
              <erros :errors="errors.source"></erros>
          </div>
          <!-- LICENCA -->
          <div class="form-group" v-bind:class="showError('licenses')">
              <label for="licenca-conteudo">Licença do Conteúdo:*</label>
              <select class="form-control form-control-lg"  
                      name="license" 
                      id="licenca-conteudo" 
                      v-model="license_id">
                  <option value="" disabled selected>« SELECIONE »</option>
                  <optgroup label="Creative Commons">
                    <option v-for="(child, i) in childsLicenses"  :key="i" 
                            :value="child.id"
                            v-text="child.name">
                    </option>
                  </optgroup>
                  <option v-for="(license, i) in licenses"  
                        :key="i" 
                        :value="license.id"
                        v-text="license.name">
                  </option>
              </select>    
                  
              <small class="text-info">
                  Escolha a opção que mais adequada à mídia que deseja publicar, conforme opções disponíveis. 
                  Se precisar de ajuda clique aqui
              </small>
              <!-- ERRORS -->
              <erros :errors="errors.licenses"></erros>
          </div>
          
          <!-- CONDIÇÕES DE USO -->
          <div class="checkbox" v-bind:class="showError('terms')">
              <label for="termosecondicoes">
                  <input id="aprovado" name="termosecondicoes" type="checkbox" v-model="terms">
                  Li e concordo com os termos e condições de uso.
              </label><br>
              <!-- ERRORS -->
              <erros :errors="errors.terms"></erros>
          </div>
          <div class="form-group">
          <!--multiselect class="form-control" v-model="tipo" :options="tipos" placeholder="Tipo de conteúdo"></multiselect-->
          </div>
          <!-- APROVAR CONTEÚDO -->
          <div class="checkbox" v-bind:class="showError('is_approved')">
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
      </div>

        <!-- COMPONENTES E NIVEIS DE ENSINO -->
        <div class="panel panel-default col-md-5">
            <div class="panel-heading">
                Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:
            </div>
            <div class="panel-body">
              <!-- IMAGEM DE DESTAQUE -->
              <div class="form-group" v-bind:class="showError('image')">
                <label for="image">Imagem de destaque:</label>
                <input type="file" class="form-control" id="image" name="image"
                        aria-describedby="image">
                <erros :errors="errors.image"></erros>
                <img class="img-responsive" :src="$store.state.conteudo.image" alt="Imagem de Destaque">
              </div>
                {{$store.state.conteudo.image}}
                
            </div>
        </div>
      </form>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapState, mapMutations } from "vuex";
import { mapFields } from "vuex-map-fields";
import showErrors from "../components/ShowErrors.vue";
import Alert from "../components/Alert.vue";
import "tui-editor/dist/tui-editor.css";
import "tui-editor/dist/tui-editor-contents.css";
import "codemirror/lib/codemirror.css";
import { Editor } from "@toast-ui/vue-editor";
import configEditor from "../editorConfig.js";
import { getInputError } from "../functions.js";

export default {
  name: "ConteudoForm",
  delay: 2000,
  components: {
    erros: showErrors,
    editor: Editor,
    alert: Alert
  },
  data() {
    return {
      autocompleteItems: [],
      categories: [],
      editorOptions: configEditor,
      license_id: "",
      canal_id: "",
      category_id: "",
      tipo_id: "",
      site: "",
      title: "",
      description: "",
      authors: "",
      source: "",
      image: "",
      tags: [],
      niveis: [],
      components: [],
      terms: false,
      is_approved: false,
      is_featured: false,
      is_site: false
    };
  },
  mounted() {
    if (this.$route.params.id) {
      this.fetchConteudo(this.$route.params);
    }
    this.fetchTiposForm();
    this.fetchLicenses();
    this.fetchCanaisForSelect();
  },
  computed: {
    ...mapState([
      "errors",
      "tiposForm",
      "conteudo",
      "licenses",
      "childsLicenses",
      "canais"
    ]),
    ...mapFields([])
  },
  methods: {
    showError(attr) {
      return getInputError(this.errors, attr);
    },
    ...mapActions([
      "fetchConteudo",
      "fetchTiposForm",
      "fetchLicenses",
      "fetchCanaisForSelect",
      "createConteudo",
      "updateConteudo"
    ]),
    send() {
      if (this.$route.params.id) {
        this.updateConteudo(this.getConteudo());
      } else {
        this.createConteudo(this.getConteudo());
      }
    },
    getConteudo() {
      return {
        license_id: this.license_id,
        canal_id: this.canal_id,
        category_id: this.category_id,
        tipo_id: this.tipo_id,
        site: this.site,
        title: this.title,
        description: this.description,
        authors: this.authors,
        source: this.source,
        image: this.image,
        tags: this.tags,
        niveis: this.niveis,
        components: this.components,
        terms: this.terms,
        is_approved: this.is_approved,
        is_featured: this.is_featured,
        is_site: this.is_site
      };
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
