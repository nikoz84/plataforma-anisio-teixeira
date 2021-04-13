<template>
    <component :is="exibirId"></component>
</template>
<script>// @ts-nocheck

import { Conteudo, Aplicativo, NotFound } from "@components/exibir";
import { Post } from "@components/blog";
import { mapState, mapActions } from "vuex";

export default {
  name: "exibir",
  components: {
    Conteudo,
    Aplicativo,
    Post,
    NotFound
  },
  created() {
    if (this.$route.params.slug == "aplicativos-educacionais") {
      this.fetchAplicativo(this.$route.params);
    } else if (this.$route.params.slug == "blog") {
      this.fetchPost(this.$route.params);
    } else {
      this.fetchConteudo(this.$route.params);
    }
  },

  computed: {
    ...mapState(["exibirId"])
  },
  methods: {
    ...mapActions(["fetchConteudo", "fetchAplicativo", "fetchPost"])
  }
};
</script>
<style lang="scss" scoped>
</style>
