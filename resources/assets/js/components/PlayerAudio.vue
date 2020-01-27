<template>
    <q-img style="height: 450px; width: 100%;" :src="image">
        <audio class="absolute-bottom" autoplay controls width="100%">
            <source :src="visualizacao.url" :type="visualizacao.mime_type">
            <source :src="download.url" :type="download.mime_type">
        </audio>
    </q-img>
</template>
<script>
export default {
  name: "PlayerAudio",
  props: ["image", "download", "visualizacao"]
};
</script>
