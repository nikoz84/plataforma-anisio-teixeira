<template>
  <nav>
    <ul class="nav nav-pills">
      <router-link v-if="canal && canal.options && canal.options.has_home" 
                tag="li" 
                :to="{ name: 'Inicio', params: {slug: $route.params.slug}}">
          <a>Home</a>
      </router-link>
      <router-link tag="li" :to="{ name: 'Listar', params: {slug: $route.params.slug}}">
          <a>Listar</a>
      </router-link>
      <router-link tag="li" :to="setUrlDenuncia">
          <a>Denúnciar</a>
      </router-link> 
      <router-link tag="li" :to="setUrlFaleConosco">
          <a>Fale Conosco</a>
      </router-link> 
    </ul>
  </nav>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "NavCanal",
  computed: {
    ...mapState(["canal"]),
    setUrlDenuncia() {
      localStorage.setItem("urlDenuncia", location.href);
      return {
        name: "DenunciaForm",
        path: "denuncia"
      };
    },
    setUrlFaleConosco() {
      return {
        name: "FaleConoscoForm",
        params: { slug: this.$route.params.slug }
      };
    }
  }
};
</script>
<style lang="stylus" scoped>

</style>
