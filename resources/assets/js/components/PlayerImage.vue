<template>
    <q-img :src="image"
        placeholder-src="/img/fundo-padrao.svg"  
        style="height: 380px; max-width: 680px;">
    </q-img>
</template>
<script>
export default {
  name: "PlayerImage",
  props: ["image"]
};
</script>
