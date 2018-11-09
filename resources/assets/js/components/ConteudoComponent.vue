<template>
    <article>
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
</template>
<script>
import PlayerApp from '../components/PlayerComponent.vue';

export default {
    name : 'ConteudoApp',
    components:{ PlayerApp },
    props:['conteudo','message' ],
    computed:{
        splitAuthors(){
            let replace = this.conteudo.authors.replace(',',';')
            return replace.split(';');
        }
    }
}
</script>
<style scoped>
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
