<template>
  <article class="q-pa-md">
    <!--Breadcrum></Breadcrum-->
    <header class="page-header">
      <h1 class="page-title" :style="`color:${canal.color};`">
          {{ canal.name }}
      </h1>
    </header>
    <nav>
      <q-tabs inline-label class="bg-primary text-white shadow-2">
        <q-route-tab name="inicio" 
              label="Sobre" 
              :to="{ name: 'Inicio', params: {slug: $route.params.slug}}"
              v-if="canal && canal.options && canal.options.has_home"/>
        <q-separator vertical inset />
        <q-route-tab name="listar" 
              label="Listar" 
              :to="{ name: 'Listar', params: {slug: $route.params.slug}}"/>
        <q-separator vertical inset />
        <q-tab label="Categorias" @click="showCategories"/>
        <q-separator vertical inset />
        <q-select 
          v-model="termSearch"
          use-input
          hide-selected
          fill-input
          :options="options"
          @filter="search">
        </q-select>
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
    
    
    <q-card class="q-gutter-xs" v-if="canal && canal.options && canal.options.has_categories">
      <q-btn v-for="(category, i) in canal.sidebar.categories" :key="i" :label="category.name">
        
      </q-btn>
    </q-card>

    <transition name="custom-classes-transition" 
                enter-active-class="animated fadeIn" 
                leave-active-class="animated fadeOut"
                mode="out-in">
      <router-view></router-view>
    </transition>
    
  </article>
  
</template>
<script>
import {
  QTabs,
  QRouteTab,
  QSeparator,
  QSpace,
  QSelect,
  QTab,
  QCard
} from "quasar";
import { mapState, mapActions } from "vuex";

export default {
  name: "canal",
  components: { QTabs, QRouteTab, QSeparator, QSpace, QSelect, QTab, QCard },
  data() {
    return {
      termSearch: "",
      options: []
    };
  },
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
    search(val) {
      console.log(val);
    },
    showCategories() {
      console.log(this.canal);
    },
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
          return this.fetchConteudos(query);
          break;
      }
    }
  }
};
</script>
<style lang="stylus" scoped>
.page-header {
  text-align: center;

  .page-title {
    margin-top: 0;
    position: relative;
    font-size: 20px;
    color: #0f285d;
    font-weight: 700;
  }
}
</style>