<template>
    <q-img :src="image"
        :placeholder-src="`/img/fundo-padrao.svg`"  
        style="height: 450px; max-width: 650px;">
    </q-img>
</template>
<script>
export default {
  name: "PlayerImage",
  props: ["image"]
};
</script>
