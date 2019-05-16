<template>
    <div>
        <conteudo v-if="this.showConteudo" ></conteudo>
        <aplicativo v-if="this.showAplicativo"></aplicativo>
        <article class="jumbotron" v-if="this.notFound">
            <h3 class="text-center">Não Encontrado</h3>
        </article>
    </div>
</template>
<script>
import client from "../client.js";
import ConteudoApp from "../components/ConteudoComponent.vue";
import AplicativoApp from "../components/AplicativoComponent.vue";
import {mapState, mapActions} from 'vuex'

export default {
  name: "exibir",
  components: { conteudo: ConteudoApp, aplicativo: AplicativoApp },
  created() {
    
    this.fetchConteudo(this.$route.params);
  },

  computed: {
    ...mapState([
      'showConteudo',
      'showAplicativo',
      'notFound'
    ])
  },
  methods: {
    ...mapActions(['fetchConteudo'])
  },
  destroyed() {
    //window.removeEventListener("scroll", this.goToTop);
  }
};
</script>
<style lang="scss" scoped>
</style>
