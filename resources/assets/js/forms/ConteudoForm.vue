<template>
    <div class="row">
        <form v-on:submit.prevent="send()">

            <div class="panel panel-default col-md-7">
                <div class="panel-heading">
                    <h2> Adicionar conteúdo digital</h2>
                </div>
                <div class="panel-body">
                    <!-- div class="tab" -->
                    <!-- TITULO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.title && errors.title.length > 0 }">
                        <label for="titulo">Título:*</label>
                        <input type="text"
                                class="form-control"
                                name="titulo"
                                id="titulo"
                                aria-describedby="titulo"
                                v-model.trim="title">
                        <small id="titulo" class="text-info">Adicione o nome original da mídia.</small><br>
                        <small class="text-danger"
                                v-if="errors.title"
                                v-for="(error,t) in errors.title"
                                v-bind:key="t"
                                v-text="error">
                        </small>
                    </div>
                    <!-- TIPO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.tipo && errors.tipo.length > 0 }">
                        <label for="tipoconteudo">Tipo de Conteúdo:*</label>
                        <select class="form-control form-control-lg" id="tipoconteudo" v-model="tipo">
                            <option value="">« SELECIONE »</option>
                            <option v-for="(tipo, i) in tipos"
                                    v-bind:value="tipo.id"
                                    v-bind:key="i">{{tipo.name}}
                            </option>
                        </select>
                        <small class="text-info">Escolha a opção mais adequada à mídia que deseja publicar, conforme tipos disponíveis.</small><br>
                        <small class="text-danger"
                                v-if="errors.tipo"
                                v-for="(error, ti) in errors.tipo"
                                v-bind:key="ti"
                                v-text="error">
                        </small>
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
                        <select class="form-control form-control-lg" id="categoria" v-model="category">
                            <option value="">« SELECIONE »</option>
                            <option v-for="(item, i) in categories"
                                    v-bind:value="item.name"
                                    v-bind:key="i">{{item.name}}
                            </option>
                        </select>
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.description && errors.description.length > 0 }">
                        <label for="descricao">Descrição:*</label>
                        <!--textarea class="form-control"
                                    id="descricao"
                                    rows="15"
                                    cols="50"
                                    v-model.trim="description"
                                    style="resize: none"></textarea-->
                        <editor v-model="description" 
                                id="descricao" 
                                height="500px" 
                                mode="wysiwyg"/>
                        <small class="text-info">Descreva á mídia de forma <b>resumida</b> e <b>objetiva</b>.
                            Esta é a primeira apresentação da mídia e pode ser o diferencial na hora do usuário escolher se acessa ou não. 
                            Verifique outras descrições para adotar o modelo mais adequado.
                        </small><br>
                        <small class="text-danger"
                                v-if="errors.description"
                                v-for="(error,d) in errors.description"
                                v-bind:key="d"
                                v-text="error">
                        </small>
                    </div>
                    <!-- AUTORES -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.authors && errors.authors.length > 0 }">
                        <label for="autores">Autores:*</label>
                        <input type="text" class="form-control" id="autores" v-model="authors">
                        <small>Nome dos autores ou grupo de trabalho responsável pelo desenvolvimento da mídia.</small><br>
                        <small class="text-danger"
                                v-if="errors.authors"
                                v-for="(error,a) in errors.authors"
                                v-bind:key="a"
                                v-text="error">
                        </small>
                    </div>
                    <!-- FONTE -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.source && errors.source.length > 0 }">
                        <label for="fonte">Fonte:*</label>
                        <input type="text" class="form-control" id="fonte" v-model="source" >
                        <small>Indique o site ou o nome da instituição que produziu a mídia.</small><br>
                        <small class="text-danger"
                                v-if="errors.source"
                                v-for="(error,s) in errors.source"
                                v-bind:key="s"
                                v-text="error">
                        </small>
                    </div>
                    <!-- LICENCA -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.license && errors.license.length > 0 }">
                        <label for="licenca-conteudo">Licença de Conteúdo:*</label>
                        <select class="form-control form-control-lg" id="licenca-conteudo" v-model="license">
                            <option value="" >« SELECIONE »</option>
                            <option value="1">Outros</option>
                            <optgroup id="idconteudolicenca-optgroup-Creative Commons" label="Creative Commons">
                                <option value="6">Atribuição CC BY</option>
                                <option value="7">Atribuição-CompartilhaIgual CC BY-SA</option>
                                <option value="8">Atribuição-SemDerivações CC BY-ND</option>
                                <option value="9">Atribuição-NãoComercial CC BY-NC</option>
                                <option value="10">Atribuição-NãoComercial-CompartilhaIgual CC BY-NC-SA</option>
                                <option value="11">Atribuição-NãoComercial-SemDerivados CC BY-NC-ND</option>
                                <option value="12">Atribuição CC 0</option>
                            </optgroup>
                            <option value="3">Todos direitos reservados (Copyright)</option>
                            <option value="4">Domínio público</option>
                            <option value="5">GPL</option>
                            <option value="13">MIT</option>
                        </select>
                        <small>
                            Escolha a opção que mais adequada à mídia que deseja publicar, conforme opções disponíveis. 
                            Se precisar de ajuda clique aqui
                        </small><br>
                        <small class="text-danger"
                                v-if="errors.license"
                                v-for="(error,li) in errors.license"
                                v-bind:key="li"
                                v-text="error">
                        </small>
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
                            <input id="termosecondicoes" type="checkbox" v-model="terms"> Li e concordo com os termos e condições de uso. 
                        </label><br>
                        <small class="text-danger"
                                v-if="errors.terms"
                                v-for="(error,te) in errors.terms"
                                v-bind:key="te"
                                v-text="error">
                        </small>
                    </div>
                    <!-- APROVAR CONTEÚDO -->
                    <div class="checkbox" v-bind:class="{ 'has-error': errors.is_aproved && errors.is_aproved.length > 0 }">
                        <label for="aprovado">
                            <input id="aprovado" type="checkbox" v-model="is_approved"> Deseja publicar o conteúdo?
                        </label><br>
                        <small class="text-danger"
                                v-if="errors.is_approved"
                                v-for="(error,ia) in errors.is_approved"
                                v-bind:key="ia"
                                v-text="error">
                        </small>
                    </div>
                </div>
                <!-- BOTÃO DE ENVIO -->
                <div class="form-group">
                    <button class="btn btn-default">Avançar</button>
                </div>
                <!-- RESPOSTA FORMULARIO -->
                <transition  name="custom-classes-transition"
                            enter-active-class="animated shake"
                            leave-active-class="animated fadeOut">
                <div v-if="!isError" class="alert alert-info" role="alert" >
                    {{ message }}
                </div>
                </transition>

            </div>

            <!-- COMPONENTES E NIVEIS DE ENSINO -->
            <div class="panel panel-default col-md-5" v-if="categories.length != 0">
                <div class="panel-heading">
                    Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:
                </div>
                <div class="panel-body">

                    <!-- COMPONENTES CURRICULARES -->


                    <!-- NIVEIS DE ENSINO -->

                </div>
            </div>

        </form>

    </div>
</template>

<script>
import client from "../client.js";
import TagsForm from "./TagsForm.vue";
import "tui-editor/dist/tui-editor.css";
import "tui-editor/dist/tui-editor-contents.css";
import "codemirror/lib/codemirror.css";
import { Editor } from "@toast-ui/vue-editor";


export default {
  name: "ConteudoForm",
  components: { TagsForm, editor: Editor },
  data() {
    return {
      title: "",
      description: "",
      authors: "",
      source: "",
      license: "",
      image: "",
      options: {},
      tipo: "",
      tipos: [],
      tags: [],
      canal: null,
      terms: false,
      is_featured: false,
      is_site: false,
      is_approved: false,
      autocompleteItems: [],
      category: "",
      category_id: "",
      categories: [],
      message: "",
      isError: true,
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
    this.getTipos();
    //console.log(this.$route.params)
    if (this.$route.params.update) {
      console.log("entrou");
      this.getConteudo();
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
    send() {
      if (this.isUpdate) {
        this.editConteudo();
      } else {
        this.createConteudo();
      }
    },
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
      form.append("token", localStorage.token);

      let resp = await client.postData("/conteudos/create", form);

      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      } else {
        console.warn(resp.data);
        this.isError = resp.data.success;
        this.message = resp.data.message;
        if (resp.data.errors) {
          this.errors = resp.data.errors;
        }

        setTimeout(() => {
          this.isError = true;
        }, 3000);
      }
    },
    async getTipos() {
      let resp = await client.getDataFromUrl("/tipos/conteudos");
      this.tipos = resp.data.tipos;
    },

    async getConteudo() {
      let resp = await client.getDataFromUrl(
        `/conteudos/${this.$route.params.id}`
      );
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
        category: this.category,
        token: localStorage.token
      };
      let resp = await client.config(
        "PUT",
        `/conteudo/update/${this.$route.params.id}`,
        params
      );
    }
  }
};
</script>
