<template>
    <div top>
        <ConteudoApp v-bind:conteudo="conteudo" v-if="showConteudo" />
        <AplicativoApp v-bind:aplicativo="aplicativo" v-if="showAplicativo"/>
        <article class="jumbotron" v-if="showMessage">
            <h3 class="text-center">{{ message }}</h3>
        </article>
    </div>
</template>
<script>
import Http from '../http.js';
import ConteudoApp from '../components/ConteudoComponent.vue';
import AplicativoApp from '../components/AplicativoComponent.vue';

let http = new Http();

export default {
    name : 'exibir',
    components:{ ConteudoApp, AplicativoApp },
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
                }
            },
            message: null,
            showMessage: false,
            showConteudo: false,
            showAplicativo: false,
            aplicativo: {
                name: '',
                description: '',
                options: {},
            }
        }
    },
    created(){
        this.getData();
        window.addEventListener('scroll', this.goToTop);
    },
    computed:{

    },
    methods: {
        async getData(){
            let id = this.$route.params.id;
            let slug = (this.$route.params.slug == 'aplicativos-educacionais') ? 'aplicativos': 'conteudos';
            let resp = await http.getDataFromUrl(`/${slug}/${id}`);
            if( slug == 'aplicativos' ){
                this.aplicativo = resp.data.aplicativo
                this.showAplicativo = true;
            }else if( slug == 'conteudos' ){
                this.conteudo = resp.data.conteudo;
                this.showConteudo = true;
            }else{
                 this.showMessage = true;
                 this.message = resp.data.message;
            }

        },
        goToTop(){
            //let top = window.pageYOffset;
            console.log('sdf')

        }
    },
    destroyed () {
        window.removeEventListener('scroll', this.goToTop);
    }

}
</script>
<style lang="scss" scoped>

</style>