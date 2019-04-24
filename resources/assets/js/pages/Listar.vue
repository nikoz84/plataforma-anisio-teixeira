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
  components: { lista: Lista },
  props: ["color"],
  data() {
    return {};
  },
  created() {
    //console.log(this.$store.state.getCanalId);
    setTimeout(() => {
      this.$store.dispatch("getConteudos", { id: this.$store.state.canalId });
    }, 2000);
  },
  watch: {
    $route(to, from) {
      this.getData();
    }
  },
  methods: {
    getData() {
      this.$store.dispatch("getConteudos", { id: this.$store.state.canalId });
    }
  },
  computed: {}
};
</script>
<style lang="sass" scoped>

</style>