<template>
    <div>
        <conteudo v-if="showConteudo" :conteudo="conteudo"></conteudo>
        <aplicativo v-if="showAplicativo"></aplicativo>
        <article class="jumbotron" v-if="notFound">
            <h3 class="text-center">Não Encontrado</h3>
        </article>
    </div>
</template>
<script>
import client from "../client.js";
import ConteudoApp from "../components/ConteudoComponent.vue";
import AplicativoApp from "../components/AplicativoComponent.vue";

export default {
  name: "exibir",
  components: { conteudo: ConteudoApp, aplicativo: AplicativoApp },
  created() {
    
    this.$store.dispatch("getConteudo", this.$route.params);
  },
  computed: {
    showConteudo() {
      return this.$store.state.showConteudo;
    },
    showAplicativo() {
      return this.$store.state.showAplicativo;
    },
    notFound() {
      return this.$store.state.notFound;
    },
    conteudo() {
      return this.$store.state.conteudo;
    }
  },
  methods: {},
  destroyed() {
    window.removeEventListener("scroll", this.goToTop);
  }
};
</script>
<style lang="scss" scoped>
</style>
