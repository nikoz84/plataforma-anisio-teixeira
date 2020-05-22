<template>
    <div class="row" v-if="conteudo && conteudo.tipo && conteudo.arquivos">
          <q-card-section class="col-12" v-if="conteudo.tipo.id == 5">
            <PlayerVideo  :download="conteudo.arquivos.download"
                        :visualizacao="conteudo.arquivos.visualizacao"
                        :image="conteudo.image">
            </PlayerVideo>
          </q-card-section>
          <q-card-section class="col-12" v-else-if="conteudo.tipo.id == 4">
            <q-img style="max-height: 380px; max-width: 640px;" :src="conteudo.image">
              <PlayerAudio :download="conteudo.arquivos.download"
                          :visualizacao="conteudo.arquivos.visualizacao"
                          :image="conteudo.image">
              </PlayerAudio>
            </q-img>
          </q-card-section>
          <q-card-section class="col-12" v-else-if="conteudo.tipo.id == 6">
            <PlayerImage :image="showImage"></PlayerImage>
          </q-card-section>
          <q-card-section class="col-12" v-else>
            <PlayerImage :image="conteudo.image"></PlayerImage>
          </q-card-section>
    </div>
</template>

<script>
import { mapState } from "vuex";
import PlayerVideo from "./PlayerVideo.vue";
import PlayerAudio from "./PlayerAudio.vue";
import PlayerImage from "./PlayerImage.vue";


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
    QSpace,
    PlayerVideo,
    PlayerAudio,
    PlayerImage
  },
  data() {
    return {
      //
    };
  },
  mounted() {
    //
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
    }
  },

  methods: {
    
  }
};
</script>
<style lang="stylus" scoped>

</style>