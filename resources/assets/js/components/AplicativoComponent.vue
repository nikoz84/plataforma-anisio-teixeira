<template>
    <article>
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 v-text="aplicativo.name"></h2>
                <small></small>
                <div class="break-word" v-html="aplicativo.description"></div>
                
                <hr class="line">
                <span class="label label-default"> Licença: </span>
                <i class="break-word" v-text="aplicativo.options"></i> 
            </div>
            <div class="panel-footer">
                <h5> Tags: </h5>
                <a class="btn btn-default tag" href="" 
                    v-for="item in aplicativo.options.tags" 
                    v-bind:key="item.id"
                    v-text="item.tag">
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
