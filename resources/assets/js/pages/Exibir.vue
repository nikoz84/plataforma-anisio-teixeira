<template>
  <component :is="exibirId"></component>
</template>
<script>
// @ts-nocheck

import { Conteudo, Aplicativo, NotFound } from "@components/exibir";
import { Post } from "@components/blog";
import { mapState, mapActions } from "vuex";

export default {
  name: "exibir",
  components: {
    Conteudo,
    Aplicativo,
    Post,
    NotFound,
  },
  created() {
    switch (this.$route.params.slug) {
      case "aplicativos-educacionais":
        this.fetchAplicativo(this.$route.params);
        break;
      case "blog":
        this.fetchPost(this.$route.params);
        break;

      default:
        this.fetchConteudo(this.$route.params);
        break;
    }
  },

  computed: {
    ...mapState(["exibirId"]),
  },
  methods: {
    ...mapActions(["fetchConteudo", "fetchAplicativo", "fetchPost"]),
  },
};
</script>
<style lang="scss" scoped>
</style>
