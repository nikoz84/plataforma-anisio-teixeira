<template>
    <article>
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 v-text="aplicativo.name"></h2>
                <small></small>
                <div class="break-word" v-html="aplicativo.description"></div>
                
                <hr class="line">
                <span class="label label-default" v-bind:style="'background-color:' + aplicativo.canal.color"> Acessos: </span>
                <i class="i-list break-word" v-text="aplicativo.options.qt_access"></i> 
            </div>
            <div class="panel-footer">
                <h5> Tags: </h5>
                <a class="btn btn-default tag" href="" 
                    v-for="tag in aplicativo.tags" 
                    v-bind:key="tag.id"
                    v-text="tag.name">
                </a>
            </div>
        </div>
    </article>
</template>
<script>

export default {
    name : 'AplicativoApp',
    components:{  },
    props:['aplicativo','message' ],
    computed:{
        splitAuthors(){
            let replace = this.aplicativo.authors.replace(',',';')
            return replace.split(';');
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
