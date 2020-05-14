<template> 
  <vue-plyr ref="plyr" style="width:100%;" class="absolute-bottom">
    <audio autoplay>
      <source :src="visualizacao.url" :type="visualizacao.mime_type" />
      <source :src="download.url" :type="download.mime_type" />
    </audio>
  </vue-plyr>
</template>
<script>
export default {
  name: "PlayerAudio",
  props: ["download", "visualizacao"],
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
