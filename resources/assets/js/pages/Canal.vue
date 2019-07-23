<template>
  <article class="q-pa-md">
    <!--Breadcrum></Breadcrum-->
    <header class="page-header">
      <h1 class="page-title">
          {{ canal.name }}
      </h1>
      <nav>
        <q-tabs inline-label class="bg-primary text-white shadow-2">
            
            <q-route-tab name="inicio" 
                  label="INÍCIO" 
                  :to="{ name: 'Inicio', params: {slug: $route.params.slug}}"
                  v-if="canal && canal.options && canal.options.has_home"/>
            <q-separator vertical inset />
            <q-route-tab name="listar" 
                  label="Listar" 
                  :to="{ name: 'Listar', params: {slug: $route.params.slug}}"/>
            <q-separator vertical inset />
            <q-space />
            <q-route-tab name="denunciar" 
                  label="Denunciar"
                  :to="setUrlDenuncia" />
            <q-separator vertical inset />
            <q-route-tab name="faleconosco" 
                  label="Fale Conosco" 
                  :to="setUrlFaleConosco"/>
        </q-tabs>
      </nav>
    </header>
    <div>
      <transition name="custom-classes-transition" 
                  enter-active-class="animated fadeIn" 
                  leave-active-class="animated fadeOut"
                  mode="out-in">
        <router-view></router-view>
      </transition>
    </div>
  </article>
  
</template>
<script>
import { QTabs, QRouteTab, QSeparator, QSpace } from "quasar";
import { mapState, mapActions } from "vuex";

export default {
  name: "canal",
  components: { QTabs, QRouteTab, QSeparator, QSpace },
  mounted() {
    this.getCanalBySlug(this.$route.params.slug).then(() => {
      this.fetchData();
    });
  },
  watch: {
    $route(to, from) {
      if (to.fullPath != from.fullPath) {
        this.getCanalBySlug(this.$route.params.slug).then(() => {
          this.fetchData();
        });
      }
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
  },
  methods: {
    ...mapActions([
      "getCanalBySlug",
      "fetchConteudos",
      "fetchAplicativos",
      "fetchPosts"
    ]),
    fetchData() {
      let query = this.$route.query;
      query.canal = localStorage.canal;
      switch (true) {
        case localStorage.canal == 9:
          return this.fetchAplicativos(query);
          break;
        case localStorage.canal == 7:
          return this.fetchPosts();
          break;
        default:
          console.log(query);
          return this.fetchConteudos(query);
          break;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
$downriver-800: #0f285d; /* 800 */

.page-header {
  text-align: center;
  .page-title {
    margin-top: 0;
    position: relative;
    font-size: 25px;
    color: $downriver-800;
    font-weight: 700;
  }
}
</style>