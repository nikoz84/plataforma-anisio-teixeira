import { mapState } from "vuex";

export const Sources = {
    
    computed: {
        ...mapState(['conteudo']),
        sources() {
            const arquivos = this.conteudo.arquivos;
            let sources = [];
            
            if(this.conteudo && arquivos && arquivos.download.hasOwnProperty('url')){
              sources.push({
                src: arquivos.download.url, 
                type: arquivos.download.mime_type
              });
            } else if (this.conteudo && arquivos && arquivos.visualizacao.hasOwnProperty('url')){
              sources.push({
                src: arquivos.visualizacao.url, 
                type: arquivos.visualizacao.mime_type});
            }
            console.log(sources);
            return sources;
          },
          image(){
            if(this.conteudo && this.conteudo.image){
                return this.conteudo.image;
            }
          }
    },
    
};