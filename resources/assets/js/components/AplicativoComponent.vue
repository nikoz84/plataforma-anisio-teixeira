<template>
    <article class="panel panel-default">
        <div class="panel-body">
            <h2 v-text="aplicativo.name"></h2>
            <button class="btn btn-info btn-xs" v-on:click="updateAplicativo()">Editar</button>
            <button class="btn btn-danger btn-xs" v-on:click="deleteAplicativo()">Apagar</button>
            <div class="row">
                <div class="col-sm-8 break-word" v-html="aplicativo.description"></div>
                <figure class="col-sm-4">
                    <img v-lazyload
                        src="/img/fundo-padrao.svg"
                        v-bind:data-src="aplicativo.image"
                        data-err="/img/fundo-padrao.svg"
                        class="img-responsive thumbnail"
                        v-bind:style="`border-color:${aplicativo.canal.color};margin: 0 auto;`"
                        alt="Imagem de destaque">
                    <a class="btn btn-success btn-block"
                        v-bind:href="aplicativo.url"
                        v-bind:style="`background-color: ${aplicativo.canal.color};margin-top:15px;`"
                        target="_blank">
                        Ir ao site
                    </a>
                </figure>
            </div>
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
    </article>
</template>
<script>
import Http from '../http.js'

const http = new Http;

export default {
    name : 'AplicativoApp',
    components:{  },
    props:['aplicativo','message' ],
    computed:{
        splitAuthors(){
            let replace = this.aplicativo.authors.replace(',',';')
            return replace.split(';');
        }
    },
    methods:{
        async deleteAplicativo(){
            let params = {
                token: localStorage.token
            }
            let resp = await http.deleteData(`/aplicativos/delete/${this.$route.params.id}`,params);
            if(resp.data.success){
                this.$router.push({ name: 'Listar', params: {slug: this.$route.params.slug}})
            }
        },
        updateAplicativo(){
            this.$router.push({ name: 'EditarAplicativo', params: {slug: this.$route.params.slug, id: this.$route.params.id, update: true }})
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
