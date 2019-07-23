<template>
  <nav>
    <q-tabs
        v-model="tab"
        inline-label
        class="bg-primary text-white shadow-2"
      >
        <q-tab name="inicio" 
              label="INÍCIO" 
              :to="{ name: 'Inicio', params: {slug: $route.params.slug}}"
              v-if="canal && canal.options && canal.options.has_home"/>
        <q-separator vertical inset />
        <q-tab name="listar" 
              label="Listar" 
              :to="{ name: 'Listar', params: {slug: $route.params.slug}}"/>
        <q-separator vertical inset />
        <q-tab name="denunciar" 
              label="Denúnciar"
              :to="setUrlDenuncia" />
        <q-separator vertical inset />
        <q-tab name="faleconosco" 
              label="Fale Conosco" 
              :to="setUrlFaleConosco"/>
    </q-tabs>
  </nav>
</template>
<script>
import { mapState } from "vuex";
import { QTabs, QTab, QSeparator } from "quasar";

export default {
  name: "NavCanal",
  components: {QTabs, QTab, QSeparator},
  data(){
    return {
      tab: ""
    }
  },
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
<style lang="scss" scoped>
.nav .nav-pills > li {
  border-bottom: solid 2px #0f285d;
}
</style>
