<template>
    <div class="q-mb-md">
        <q-card>
          <q-card-section v-if="tipo.id == 5">
            <video autoplay controls width="100%" height="360">
              <source v-if="arquivos.visualizacao.url" :src="arquivos.visualizacao.url" :type="arquivos.visualizacao.mime_type">
              <source v-if="arquivos.download.url" :src="arquivos.download.url" :type="arquivos.download.mime_type">
            </video>
          </q-card-section>
          <q-card-section v-if="tipo.id == 4">
                <audio autoplay controls width="100%">
                  <source :src="arquivos.visualizacao.url" :type="arquivos.visualizacao.mime_type">
                  <source :src="arquivos.download.url" :type="arquivos.download.mime_type">
                </audio>
          </q-card-section>
          <q-card-section>
            {{arquivos}} - {{tipo}}
          </q-card-section>
          
          <q-card-actions>
            <q-btn-group outline>
              <q-btn outline
                    v-if="arquivos && arquivos.download.url"
                    @click="download"
                    color="primary" 
                    label="Baixar Arquivo" />
              <q-btn v-if="arquivos && arquivos.guia.url" 
                    filled 
                    @click="download('guia')"
                    color="primary"
                    label="Baixar Guia Pedagógica" 
                    icon-right="cloud_download" />
              <q-btn outline color="primary" label="Compartilhar" @click="share"/>
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
      downloadVideo: false
    };
  },
  mounted() {
    //this.$refs.videoRef.src = ``;
    //console.log()
  },
  computed: {
    videos() {}
  },

  methods: {
    download(file) {
      switch (file) {
        case "video":
          console.log("download video");
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