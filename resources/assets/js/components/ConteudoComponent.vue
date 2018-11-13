<template>
    <article>
        <PlayerApp :tipo="conteudo.options.tipo"
                :download="conteudo.options.download"
                :visualizacao="conteudo.options.visualizacao"
                :guia="conteudo.options.guia"
                :id="conteudo.id"
                />
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 v-text="conteudo.title"></h2>
                <small></small>
                <div class="break-word" v-html="conteudo.description"></div>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Fonte: </span> 
                    <i class="i-list break-word">{{ conteudo.source }}</i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Autores: </span>
                <i class="i-list break-word" v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i> 
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Componentes: </span>
                <i class="i-list break-word" 
                    v-for="(item) in conteudo.options.componentes"
                    v-bind:key="item.id"
                    v-text="item.componente"
                    ></i> 
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Licença: </span>
                <i class="i-list break-word" v-text="conteudo.options"></i> 
            </div>
            <div class="panel-footer">
                <span class="label label-default" v-bind:style="backgroundColor"> Tags: </span>
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
        },
        backgroundColor(){
            let color = (!this.conteudo.canal) ? '#333': this.conteudo.canal.options.color;
            return `background-color: ${color}`;
        }
    }
}
</script>
<style scoped>
i::before {
  content: " » ";
  padding-right: 5px;
  padding-left: 7px;
}
</style>
