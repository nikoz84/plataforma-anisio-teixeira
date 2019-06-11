<template>
  <nav>
    <ul class="nav nav-pills">
      <router-link tag="li" :to="{ name: 'Inicio', params: {slug: $route.params.slug}}" exact>
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
export default {
  name: "NavCanal",
  computed: {
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
<style lang="scss" scoped>
</style>
