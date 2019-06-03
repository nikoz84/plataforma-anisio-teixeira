<template>
    <div>
        <component :is="exibirId"></component>
    </div>
</template>
<script>
import Conteudo from "../components/Conteudo.vue";
import Aplicativo from "../components/Aplicativo.vue";
import NotFound from "../components/NotFound.vue";
import { mapState, mapActions } from "vuex";

export default {
  name: "exibir",
  components: {
    Conteudo,
    Aplicativo,
    NotFound
  },
  created() {
    if (this.$route.params.slug == "aplicativos-educacionais") {
      this.fetchAplicativo(this.$route.params.id);
    } else {
      this.fetchConteudo(this.$route.params.id);
    }
  },

  computed: {
    ...mapState(["exibirId"])
  },
  methods: {
    ...mapActions(["fetchConteudo", "fetchAplicativo"])
  }
};
</script>
<style lang="scss" scoped>
</style>
