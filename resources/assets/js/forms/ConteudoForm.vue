<template>
    <div class="row">
        <form v-on:submit.prevent="createConteudo()">

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
                        <textarea class="form-control"
                                    id="descricao"
                                    rows="15"
                                    cols="50"
                                    v-model.trim="description"
                                    style="resize: none"></textarea>
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
                    <div class="form-group" v-bind:class="{ 'has-error': errors.arquivo && errors.arquivo.length > 0 }">
                        <img class="img-responsive" width="150" height="150" v-if="image" :src="image">
                        <label for="arquivo">Arquivo:</label>
                        <input type="file" class="form-control" id="arquivo" name="arquivo"
                                aria-describedby="arquivo"
                                v-on:change="onFileChange($event)">
                        <small class="text-danger"
                                v-if="errors.image"
                                v-for="(error,f) in errors.image"
                                v-bind:key="f"
                                v-text="error">
                        </small>
                        <!--<small v-if="this.file">
                            {{ ` ${this.file.name} -- ${this.file.size} -- ${this.file.type} `}}
                        </small>-->
                    </div>
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
                    <button class="btn btn-default">Enviar</button>
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
            <div class="panel panel-default col-md-5">
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
import Http from '../http.js';

const http = new Http();

export default {
    name: 'ConteudoForm',
    components: {},
    data(){
        return {
            title: '',
            description:null,
            authors:null,
            source:null,
            license: '',
            options: {},
            tipo: '',
            tipos: [],
            tags: [],
            canal: null,
            terms: false,
            is_featured: false,
            is_site:false,
            is_approved: false,
            autocompleteItems: [],
            category: '',
            categories:[],
            site: '',
            message : '',
            isError : true,
            errors: {
                title: [],
                description: [],
                tipos: [],
                authors: [],
                license: [],
                terms: [],
                is_approved: [],
            },


        }

    },
    created() {
        this.getTipos();
        if(this.$route.params.update){
            this.getConteudo();
            this.isUpdate = true;
            this.textButton = 'Editar';
        }
    },
    computed:{

    },
    methods:{
        async createConteudo(){

            let params = {
                tipo: this.tipo,
                canal_id: localStorage.idCanal,
                title: this.title,
                description:this.description,
                authors:this.authors,
                source:this.source,
                license_id:this.license,
                terms: this.terms,
                is_featured: this.is_featured,
                is_site: this.is_site,
                is_approved: this.is_approved,
                options: JSON.stringify(this.options),
                token: localStorage.token
            };

            let resp = await http.postData('/conteudos/create', params);

            if(resp.data.success){
                console.log(resp);
                this.$router.push('listar')
            }else{
                console.warn(resp.data);
                this.isError = resp.data.success;
                this.message = resp.data.message;
                if(resp.data.errors){
                    this.errors = resp.data.errors;
                }

                setTimeout(()=>{
                    this.isError = true;
                },3000)
            }

        },
        async getTipos(){
            let resp = await http.getDataFromUrl('/tipos/conteudos');
            this.tipos = resp.data.tipos;
        },

        async getConteudo(){
            let resp = await http.getDataFromUrl(`/conteudo/${this.$route.params.id}`);
            if(resp.data.success){
                this.name = resp.data.conteudo.name;
                this.category = resp.data.conteudo.category_id;
                this.description = resp.data.conteudo.description;
                this.url = resp.data.conteudo.url;
                this.is_featured = resp.data.conteudo.is_featured;
                this.image = resp.data.conteudo.image;
            }
        },
        async editConteudo(){
            console.log('editar')
            let params ={
                name: this.name,
                category: this.category,
                canal: localStorage.idCanal,
                token: localStorage.token
            }
            console.log(params)
            let resp = await http.config('PUT',`/aplicativos/update/${this.$route.params.id}`,params);

            console.log(resp)
        }

    }

}
</script>
