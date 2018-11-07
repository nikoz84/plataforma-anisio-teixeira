<template>
    <div>
        <article v-if="this.conteudo != null">
            <PlayerApp :tipo="conteudo.options.tipo"
                    :download="conteudo.options.download"
                    :visualizacao="conteudo.options.visualizacao"
                    :guia="conteudo.options.guia"
                    />
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 v-text="conteudo.title"></h2>
                    <small></small>
                    <div class="break-word" v-html="conteudo.description"></div>
                    <hr class="line">
                    <span class="label label-default"> Fonte: </span> 
                        <i class="break-word">{{ conteudo.source }}</i>
                    <hr class="line">
                    <span class="label label-default"> Autores: </span>
                    <i class="break-word" v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i> 
                    <hr class="line">
                    <span class="label label-default"> Componentes: </span>
                    <i class="break-word" 
                       v-for="(item) in conteudo.options.componentes"
                       v-bind:key="item.id"
                       v-text="item.componente"
                       ></i> 
                    <hr class="line">
                    <span class="label label-default"> Licença: </span>
                    <i class="break-word" v-text="conteudo.options"></i> 
                </div>
                <div class="panel-footer">
                    <h5> Tags: </h5>
                    <a class="btn btn-default tag" href="" 
                        v-for="item in conteudo.options.tags" 
                        v-bind:key="item.id"
                        v-text="item.tag">
                    </a>
                </div>
            </div>
        </article>
        <article class="jumbotron" v-else>
            <h1 class="text-center">{{ message }}</h1>
        </article>
    </div>
</template>
<script>
import Http from '../http.js';
import PlayerApp from '../components/PlayerComponent.vue';

let http = new Http();

export default {
    name : 'exibir',
    components:{PlayerApp},
    data() {
        return {
            conteudo: {
                title: '',
                description: '',
                authors: '',
                source: '',
                createdAt: '',
                options: {
                    tags: [],
                    componentes:[],
                    tipo: '',
                    download:'',
                    visualizacao:'',
                    guia:''
                },
                
            }
        }
    },
    created(){
        this.getConteudo(this.$route.params.id)
    },
    computed:{
        splitAuthors(){
            let replace = this.conteudo.authors.replace(',',';')
            return replace.split(';');
        }
    },
    methods: {
        async getConteudo(id){
            let params = {
                token: localStorage.token
            };
            let resp = await http.getDataFromUrl(`/conteudos/${id}`, params);
            console.log(resp.data);     
            if(resp.data.success){
                this.conteudo = resp.data.conteudo;
            }else{
                this.conteudo = null;
                this.message = resp.data.message;
            }    
            
        }
    }
}
</script>
<style lang="scss" scoped>
.break-word {
    word-wrap: break-word;
}
.tag{
    margin-right: 10px;
    margin-bottom: 5px;
}
.label{
    padding: 6px;
    margin-right: 15px;
}

i:before{
  content: " » ";
  padding-right: 5px;
  padding-left: 7px;
}
hr.line {
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #a2a9af, #ccc);
}
</style>