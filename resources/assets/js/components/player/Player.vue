<template>
  <div v-if="conteudo && conteudo.tipo && conteudo.arquivos">
    
      <q-media-player
        type="video"
        :sources="sources"
        autoplay
        :poster="showImage"
        :volume="25"
        v-if="tipo.id == 5"
      ></q-media-player>
    
      <q-media-player
        type="audio"
        :sources="sources"
        autoplay
        :poster="showImage"
        :volume="25"
        v-else-if="tipo.id == 4"
      ></q-media-player>
    
    
      <q-img v-else :src="showImage"
          placeholder-src="/img/fundo-padrao.svg" 
          style="height: 380px; max-width: 680px;">
          <div class="absolute-bottom text-subtitle1 text-center">
            Default
          </div>
      </q-img>
 
  </div>  
</template>

<script>
import { mapState } from "vuex";
import {
  QCard,
  QCardActions,
  QCardSection,
  QBtnGroup,
  QBtn,
  QImg,
  QSpace
} from "quasar";

export default {
  name: "Player",
  components: {
    QCard,
    QCardActions,
    QCardSection,
    QBtn,
    QBtnGroup,
    QImg,
    QSpace
  },
  props: ["arquivos", "tipo"],
  data() {
    return {
      image: null,
      selectPlayer: null,
      type: null
    };
  },
  computed: {
    ...mapState(["conteudo"]),
    showImage() {
      if (this.conteudo && this.conteudo.arquivos.visualizacao.url) {
        return this.conteudo.arquivos.visualizacao.url;
      } else if (this.conteudo && this.conteudo.arquivos.download.url) {
        return this.conteudo.arquivos.visualizacao.url;
      } else {
        return this.conteudo.image;
      }
    },
    sources() {
      if(this.conteudo.arquivos){
        return [
          { 
            src: this.arquivos.visualizacao.url, 
            type: this.arquivos.visualizacao.mime_type
          },
          { 
            src: this.arquivos.download.url, 
            type: this.arquivos.download.mime_type
          }
        ]
      }
    }
  }
};
</script>
<style lang="stylus" scoped>

</style>