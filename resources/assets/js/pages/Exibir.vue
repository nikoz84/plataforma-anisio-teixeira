<template>
    <div>
        <component :is="exibirId"></component>
    </div>
</template>
<script>
import Conteudo from "../components/Conteudo.vue";
import Aplicativo from "../components/Aplicativo.vue";
import NotFound from "../components/NotFound.vue";
import {mapState, mapActions} from 'vuex'

export default {
  name: "exibir",
  components: { conteudo: Conteudo, aplicativo: Aplicativo, notfound:NotFound },
  created() {
    
    this.fetchConteudo(this.$route.params);
  },

  computed: {
    ...mapState([
      'exibirId'
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
