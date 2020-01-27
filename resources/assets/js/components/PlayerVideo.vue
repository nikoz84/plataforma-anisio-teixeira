<template>
    <video autoplay 
            controls 
            width="100%" 
            height="360" 
            :poster="image">
        <source v-if="visualizacao.url" 
            :src="visualizacao.url" 
            :type="visualizacao.mime_type">
        <source v-if="download.url" 
                      :src="download.url" 
                      :type="download.mime_type">
    </video>
</template>
<script>
export default {
  name: "PlayerVideo",
  props: ["visualizacao", "download", "image"]
};
</script>
