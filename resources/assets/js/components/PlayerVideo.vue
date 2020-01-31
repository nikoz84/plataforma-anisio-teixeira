<template>
  <vue-plyr ref="plyr" style="max-width:640px">
    <video autoplay 
            width="640" 
            height="360"
            id="video-control"
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
    this.controlVolume();
  },
  methods: {
    async controlVolume() {
      let player = await this.$refs.plyr.player;
      player.volume = 0.2;
    }
  }
};
</script>
