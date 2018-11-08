<template>
    <div>
        <ConteudoApp v-bind:conteudo="conteudo" />
    </div>
</template>
<script>
import Http from '../http.js';
import ConteudoApp from '../components/ConteudoComponent.vue';

let http = new Http();

export default {
    name : 'exibir',
    components:{ ConteudoApp },
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
        if(this.$route.params.slug == 'aplicativos-educacionais'){
            this.getAplicativo(this.$route.params.id);
        }else{
            this.getConteudo(this.$route.params.id);
        }
        
        
        
    },
    computed:{
        splitAuthors(){
            let replace = this.conteudo.authors.replace(',',';')
            return replace.split(';');
        }
    },
    methods: {
        async getConteudo(id){
            let resp = await http.getDataFromUrl(`/conteudos/${id}`);
            
            if(resp.data.success){
                this.conteudo = resp.data.conteudo;
            }else{
                this.conteudo = null;
                this.message = resp.data.message;
            }    
        },
        async getAplicativo(id){
            let resp = await http.getDataFromUrl(`/aplicativos/${id}`);
            console.log(resp)
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