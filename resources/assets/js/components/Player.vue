<template>
    <q-card class="row" v-if="conteudo && conteudo.tipo && conteudo.arquivos">
          <q-card-section class="col-sm-12" v-if="conteudo.tipo.id == 5">
            <PlayerVideo class="row" :download="conteudo.arquivos.download"
                        :visualizacao="conteudo.arquivos.visualizacao"
                        :image="conteudo.image">
            </PlayerVideo>
          </q-card-section>
          <q-card-section class="col-sm-12" v-else-if="conteudo.tipo.id == 4">
            <q-img style="max-height: 380px; max-width: 640px;" :src="conteudo.image">
              <PlayerAudio :download="conteudo.arquivos.download"
                          :visualizacao="conteudo.arquivos.visualizacao"
                          :image="conteudo.image">
              </PlayerAudio>
            </q-img>
          </q-card-section>
          <q-card-section class="col-sm-12" v-else-if="conteudo.tipo.id == 6">
            <PlayerImage :image="showImage"></PlayerImage>
          </q-card-section>
          <q-card-section class="col-sm-12" v-else>
            <PlayerImage :image="conteudo.image"></PlayerImage>
          </q-card-section>
          <q-card-section >
            <q-separator></q-separator>
            <small>
              Tipo de Conteúdo: 
              <q-badge color="secondary">{{conteudo.tipo.name}}</q-badge>
            </small>
            <small>
                Acessos: 
                <q-badge color="secondary">{{conteudo.qt_access}}</q-badge>
              </small>
              <small v-if="conteudo.tipo.id != 8">
                Downloads: 
                <q-badge color="secondary">{{conteudo.qt_downloads}}</q-badge>
              </small>
          </q-card-section>
          <q-card-actions class="q-mt-lg">
            <q-btn-group outline>
              <q-btn outline
                    v-if="conteudo.arquivos && conteudo.arquivos.download.url"
                    @click="download('download')"
                    color="primary" 
                    label="Baixar Arquivo" />
              <q-btn v-if="conteudo.arquivos && conteudo.arquivos.guia.url" 
                    filled 
                    @click="download('guia')"
                    color="primary"
                    label="Baixar Guia Pedagógica" 
                    icon-right="cloud_download" />
              <q-btn outline color="primary" label="Compartilhar" @click="share"/>
            </q-btn-group>
          </q-card-actions>
    </q-card>
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
    download(file) {
      switch (file) {
        case "download":
          if (this.conteudo.arquivos.download) {
            console.info("download");
          } else {
            console.warn("vissualia");
          }
          break;
        case "guia":
          console.warn("guia");
          break;
      }
    },
    share() {
      console.log("compartilhar");
    }
  }
};
</script>