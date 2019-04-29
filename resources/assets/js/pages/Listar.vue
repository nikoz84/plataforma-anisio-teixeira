<template>
    <div>
        <lista></lista>
    </div>
</template>
<script>
import Lista from "../components/ListComponent.vue";
import client from "../client.js";

export default {
  name: "Listar",
  components: { lista: Lista }
};
</script>
<style lang="sass" scoped>

</style>