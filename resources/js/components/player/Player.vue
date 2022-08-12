<template>
  <div
    class="row justify-center"
    v-if="conteudo && conteudo.tipo && conteudo.arquivos"
  >
    <q-media-player
      type="video"
      :sources="sources"
      autoplay
      :poster="showImage"
      :volume="25"
      :show-big-play-button="true"
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

    <q-img
      v-else
      :src="showImage"
      :placeholder-src="`/img/fundo-padrao.svg`"
      :style="onLoadImage(conteudo.image)"
    >
      <div
        class="absolute-bottom text-center"
        v-if="conteudo && conteudo.options && conteudo.options.site"
      >
        <q-btn
          color="primary"
          type="a"
          target="_blank"
          :href="conteudo.options.site"
        >
          IR AO SITE
        </q-btn>
      </div>
    </q-img>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { QMediaPlayer } from "@quasar/quasar-ui-qmediaplayer";

export default {
  name: "Player",
  components: {
    QMediaPlayer,
  },
  props: ["arquivos", "tipo"],
  data() {
    return {
      image: null,
      selectPlayer: null,
      type: null,
      width: null,
      height: null,
    };
  },
  computed: {
    ...mapState(["conteudo"]),
    showImage() {
      if (this.conteudo && this.conteudo.image) {
        return this.conteudo.image;
      }
    },
    sources() {
      const arquivos = this.conteudo.arquivos;
      let data = [];

      if (arquivos.visualizacao) {
        data.push({
          src: arquivos.visualizacao.url,
          type: arquivos.visualizacao.mime_type,
        });
      }
      if (arquivos.download) {
        data.push({
          src: arquivos.download.url,
          type: arquivos.download.mime_type,
        });
      }

      return data;
    },
  },
  methods: {
    onLoadImage(src) {
      let img = new Image();
      img.src = src;

      img.onload = () => {
        this.width = "with:100%";
        this.height = "max-height:400px";
        //this.width = img.width < 460 ? `width:${img.width}px;` : 'width: 100%;';
        //this.height = img.height > 380 ? 'height: 380px; max-height:400px;': `height:${img.height};max-height:400px;`;
      };
    },
  },
};
</script>
<style lang="stylus" scoped></style>
