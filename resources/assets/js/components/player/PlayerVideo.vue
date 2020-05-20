<template>
  <vue-plyr ref="plyr">
    <video  width="1280" 
            height="720"
            id="video-control"
            preload="none"
            :poster="image">
            <source v-if="visualizacao.url" 
              :src="visualizacao.url" 
              :type="visualizacao.mime_type">
            <source v-if="download.url" 
              :src="download.url" 
              :type="download.mime_type">
    </video>
  </vue-plyr>
</template>
<script>
export default {
  name: "PlayerVideo",
  props: ["visualizacao", "download", "image"],
  mounted() {
    this.initVideo();
  },
  methods: {
    async initVideo() {
      
      let player = await this.$refs.plyr.player;
      player.volume = 0.2;
      
      
    }
  }
};
</script>
