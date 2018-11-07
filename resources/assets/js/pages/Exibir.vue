<template>
    <article>
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 v-text="conteudo.title"></h2>
                <div v-html="conteudo.description"></div>
                <hr>
                <span class="label label-default"> Fonte: </span> 
                    <i>{{ conteudo.source }}</i>
                <hr>
                <span class="label label-default"> Autores: </span>
                <i v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i> 
                 
            </div>
            <div class="panel-footer">
                <a class="btn btn-default tag" href="" 
                    v-for="(item, i) in conteudo.options.tags" 
                    v-bind:key="i"
                    v-text="item.tag">
                </a>
            </div>
        </div>
            
    </article>
</template>
<script>
import Http from '../http.js';

let http = new Http();

export default {
    name : 'exibir',
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
                    tipo: ''
                },
                
            }
        }
    },
    created(){
        this.getConteudo(this.$route.params.id)
    },
    computed:{
        splitAuthors(){
            let arrayAuthors = [];
            arrayAuthors = this.conteudo.authors.split(',');
            
            console.warn(arrayAuthors) 
            return arrayAuthors;
        }
    },
    methods: {
        async getConteudo(id){
            let params = {
                token: localStorage.token
            };
            let resp = await http.getDataFromUrl(`/conteudos/${id}`, params);
                 
            if(resp.data.success){
                this.conteudo = resp.data.conteudo;
            }    
            console.log(this.conteudo)
        }
    }
}
</script>
<style lang="scss" scoped>
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
}
</style>