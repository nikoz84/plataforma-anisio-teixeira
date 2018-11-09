<template>
    <div>
        <ConteudoApp v-bind:conteudo="conteudo" v-if="showConteudo" />
        <AplicativoApp v-bind:aplicativo="aplicativo" v-if="showAplicativo"/>
        <article class="jumbotron" v-if="showMessage">
            <h1 class="text-center">{{ message }}</h1>
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
        if(this.$route.params.slug == 'aplicativos-educacionais'){
            this.getAplicativo(this.$route.params.id);
            
        }else{
            this.getConteudo(this.$route.params.id);
            
        }
        
        
        
    },
    computed:{
        
    },
    methods: {
        async getConteudo(id){
            let resp = await http.getDataFromUrl(`/conteudos/${id}`);
            
            if(resp.data.success){
                this.conteudo = resp.data.conteudo;
                this.showConteudo = true;
            }else{
                this.showMessage = true;
                this.message = resp.data.message;
            }    
        },
        async getAplicativo(id){
            let resp = await http.getDataFromUrl(`/aplicativos/${id}`);
            console.log(resp)
            if(resp.data.success){
                this.aplicativo = resp.data.aplicativo;
                this.showAplicativo = true;
            }else{
                this.showMessage = true;
                this.message = resp.data.message;
            }
        }
    }
}
</script>
<style lang="scss" scoped>

</style>