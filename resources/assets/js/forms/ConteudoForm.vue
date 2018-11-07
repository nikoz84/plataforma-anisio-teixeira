<template>
    <div class="row">
        <form v-on:submit.prevent="createConteudo()">
            
            <div class="panel panel-default col-md-7">
                <div class="panel-heading">
                    Adicionar conteúdo digital
                </div>
                <div class="panel-body">
                    <!-- TITULO -->
                    <div class="form-group">
                        <label for="titulo">Título:*</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="titulo" v-model.trim="title">
                        <small id="titulo" class="form-text text-muted">Adicione o nome original da mídia.</small>
                    </div>
                    <!-- TIPO -->
                    <div class="form-group">
                        <label for="estado">Tipo de Conteúdo:*</label>
                        <select class="form-control form-control-lg" id="licenca-relacionada" v-model="tipo">
                            <option value="">« SELECIONE »</option>
                            <option value="7">Animação/Simulação</option>
                            <option value="3">Apresentação</option>
                            <option value="4">Áudio</option>
                            <option value="1">Documento/Experimento</option>
                            <option value="6">Imagem</option>
                            <option value="2">Planilha</option>
                            <option value="10">Sequência Didática</option>
                            <option value="8">Site</option>
                            <option value="9">Software Educacional</option>
                            <option value="5">Vídeo</option>
                        </select>
                    </div>
                    <!-- CATEGORIA -->
                    <div class="form-group" v-if="categories.length != 0">
                        <label for="estado">Categoria de Conteúdo:*</label>
                        <select class="form-control form-control-lg" id="categoria" v-model="category">
                            <option value="">« SELECIONE »</option>
                            <option v-for="(item, i) in categories" v-bind:value="item.name" v-bind:key="i">{{item.name}}</option>
                        </select>
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group">
                        <label for="descricao">Descrição:*</label>
                        <textarea class="form-control" id="descricao" v-model="description" style="resize: none"></textarea>
                    </div>
                    <!-- TAGS -->
                    <div class="form-group">
                        <label for="palavra-chave">Palavras-Chave:*</label>
                        <input type="text" class="form-control" v-model="tag"
                                        v-bind:tags="tags"
                                        v-bind:autocomplete-items="autocompleteItems"
                                        v-on:tags-changed="update"
                        />
                    </div>
                    <!-- AUTORES -->
                    <div class="form-group">
                        <label for="autores">Autores:*</label>
                        <input type="text" class="form-control" id="autores" v-model="authors">
                    </div>
                    <!-- FONTE -->
                    <div class="form-group">
                        <label for="fonte">Fonte:*</label>
                        <input type="text" class="form-control" id="fonte" v-model="source">
                    </div>
                    <!-- LICENCA -->
                    <div class="form-group">
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
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-default">Enviar</button>
                </div>

                <transition  name="custom-classes-transition" 
                            enter-active-class="animated shake" 
                            leave-active-class="animated fadeOut">
                <div v-if="!isError" class="alert alert-info" role="alert" >
                    {{ message }}
                </div>
                </transition>

            </div>
            <div class="panel panel-default col-md-5">
                <div class="panel-heading">
                    Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:
                </div>
                <div class="panel-body">
                    
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Áreas de Conhecimento</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Ciências da natureza<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Humanas<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Linguagens e seus códigos<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Matemática<br/>

                   <br>
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Linguagens Artísticas</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Artes Visuais<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Audiovisual<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Circo<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Dança<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Literatura<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Música<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Teatro<br/>

                    <br>
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Temas Transversais</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Educação Ambiental<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Especial<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Gênero e Sexualidade<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>História e Cultura Africana<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>História e Cultura Indígena<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Pluralidade Cultural<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Saúde<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Trabalho e Consumo<br/>
                    <input type="checkbox"     name="item-superior1" value="css"/>Ética e Cidadania<br/>

                    <br>
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Séries - Educação Infantil</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Creche<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Pré-Escola<br/>

                    <br>
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Séries - Ensino Fundamental</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>1º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>2º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>3º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>4º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>5º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>6º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>7º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>8º Ano<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>9º Ano<br/>

                    <br>
                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Séries - Ensino Médio</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>1º Série<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>2º Série<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>3º Série<br/>

                    <br>
                    <strong>Componente curricular/Disciplina</strong>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Ensino Médio</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Arte<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Biologia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Filosofia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Geografia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>História<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Literatura<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Estrangeira<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Portuguesa<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemáticabr/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Química<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Sociologia<br/>
                    
                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Educação Infantil</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Arte Visual<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Linguagem oral e escrita<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemática<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Movimento<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Natureza e Sociedade<br/>

                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Ensino Fundamental Inicial</label>
                        </div>
                    </div>

                    <input type="checkbox"     name="item-superior1" value="java"/>Alfabetização<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Artes<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Naturais<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Geografia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>História<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Portuguesa<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemática<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Meio Ambiente<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Orientação Sexual<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Pluralidade Cultural<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Saúde<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ética<br/>

                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Ensino Fundamental Final</label>
                        </div>
                    </div>
                   
                    <input type="checkbox"     name="item-superior1" value="html"/>Artes<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Naturais<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Geografia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>História<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Estrangeira<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Portuguesa<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemática<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Meio Ambiente<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Orientação Sexual<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Pluralidade Cultural<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Saúde<br/>

                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Educação Escolar Indígena</label>
                        </div>
                    </div>
                   
                    <input type="checkbox"     name="item-superior1" value="html"/>Artes<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Geografia<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>História<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Línguas<br/>
                    
                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Ensino Superior</label>
                        </div>
                    </div>
                   
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciência Sociais Aplicadas<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Agrárias<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Biológicas<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Exatas e da Terra<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Humanas<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências da Saúde<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Engenharias<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Interdisciplinar<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Lingüística, Letras e Artes<br/>

                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Educação de Jovens e Adultos 1</label>
                        </div>
                    </div>
                   
                    <input type="checkbox"     name="item-superior1" value="html"/>Estudo da Sociedade e da Natureza<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Portuguesa<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemática<br/>

                    <br>

                    <div class="col-auto my-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input item-superior" id="item-superior" name="item-superior">
                            <label class="custom-control-label" for="customControlAutosizing">Educação de Jovens e Adultos 2</label>
                        </div>
                    </div>
                   
                    <input type="checkbox"     name="item-superior1" value="html"/>Artes<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Ciências Naturais<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Educação Física<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>História<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Estrangeira<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Língua Portuguesa<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Matemática<br/>
                    <input type="checkbox"     name="item-superior1" value="html"/>Outros<br/>

                </div>
            </div>

        </form>
    </div>
</template>

<script>
import Http from '../http.js';


export default {
    name: 'ConteudoForm',
    components: {},
    data(){
        return {
            
            tipo: '',
            title: null,
            description:null,
            authors:null,
            source:null,
            license:'',
            options: {},
            canal: null,
            tags: [],
            tag: '',
            is_featured: false,
            is_site:false,
            is_approved: false,
            autocompleteItems: [],
            category: '',
            categories:[],
            message : 'Mensagem aqui',
            isError : true
        }

    },
    created:function(){
        this.getOptions();
    },
    computed:{

    },
    methods:{
        async createConteudo(){
            this.options ={
                category: this.category,
                tipo: this.tipo,
                tags: this.tags,
            };
            let params = {
                canal_id: localStorage.idCanal,
                title: this.title,
                description:this.description,
                authors:this.authors,
                source:this.source,
                license_id:this.license,
                is_featured: this.is_featured,
                is_site: this.is_site,
                is_approved: this.is_approved,
                options: JSON.stringify(this.options),
                token: localStorage.token
            };
            console.warn(params);
            
            let http = new Http();
            let resp = await http.postData('/conteudos/create', params);

            if(!resp.data.success){
                this.isError = resp.data.success;
                this.message = resp.data.message;
                
                setTimeout(()=>{
                this.isError = true; 
                },3000)
            }else{
                this.isError = resp.data.success;
                console.log(resp.data);
            }

            /*console.log(resp);
            if(resp.data.success){
                console.log(resp.data);
            }*/
            
        },
        update(newTags) {
            this.autocompleteItems = [];
            this.tags = newTags;
        },
        async getItems(){
            if (this.tag.length === 0) return;
            let http = new Http();
            let params = {token:localStorage.token};
            let resp = await http.getDataFromUrl(`/tags/search/${this.tag}`, params);

            if(resp.data.success){
                this.autocompleteItems = resp.data.paginator.data.map(a =>{
                    return {name: a.name, id: a.id  };
                });

            }

        },
        async getOptions(){
            let http = new Http();
            let params = {
                token: localStorage.token
            };
            let name= this.$route.params.slug;
            let resp = await http.postData(`/options/name/${name}`);
            
            if(resp.data.success && resp.data.options != null ){
                this.categories = resp.data.options.meta_data.categories
            }
        }
    },
    watch:{
        'tag':'getItems'
    }

}
</script>
