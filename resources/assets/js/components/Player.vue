<template>
    <div>
        <q-card>
          <q-card-section v-if="tipo.id == 5">
            <video  width="640" height="360">
              <source v-for="(video, i) in videos" :key="i" :src="video.source" :type="video.mime">
            </video>
          </q-card-section>
          <q-card-section>
                {{arquivos}} - {{tipo}}
          </q-card-section>
          <q-card-actions>
            <q-btn-group outline>
              <q-btn outline color="primary" label="Baixar" />
              <q-btn v-if="arquivos && arquivos.guia" outline color="primary" label="Guia Pedagógica" icon-right="watch_later" />
              <q-btn outline color="primary" label="Third" />
            </q-btn-group>
          </q-card-actions>
        </q-card>
    </div>
</template>

<script>
import { QCard, QCardActions, QCardSection, QBtnGroup, QBtn } from "quasar";

export default {
  name: "Player",
  components: { QCard, QCardActions, QCardSection, QBtn, QBtnGroup },
  props: ["arquivos", "tipo"],
  data() {
    return {
      is_video: false
    };
  },
  mounted() {
    //this.$refs.videoRef.src = ``;
    //console.log()
  },
  computed: {
    videos() {
      if (this.tipo.id == 5 && this.arquivos.download) {
        this.is_video = true;
        return [
          {
            source: this.arquivos.download.url,
            mime: this.arquivos.download.mime_type
          },
          {
            source: this.arquivos.visualizacao.url,
            mime: this.arquivos.visualizacao.mime_type
          }
        ];
      }
    }
  },

  methods: {
    visualizar() {}
  }
};
</script>