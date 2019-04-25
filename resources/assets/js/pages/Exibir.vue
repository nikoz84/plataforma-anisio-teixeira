<template>
    <div>
        <conteudo v-if="showConteudo"></conteudo>
        <aplicativo v-if="showAplicativo"></aplicativo>
        <article class="jumbotron" >
            <h3 class="text-center"></h3>
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
    //console.log(this.$store.state.contudo);
  },
  computed: {
    conteudo() {
      let payload = {
        slug: this.$route.params.slug,
        id: this.$route.params.id
      };
      this.$store.dispatch("getConteudo", payload);

      //return this.$store.state.conteudo;
    },
    showConteudo() {
      return this.$store.state.showConteudo;
    },
    showAplicativo() {
      return this.$store.state.showAplicativo;
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
