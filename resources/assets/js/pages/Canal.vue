<template>
  <section class="q-pa-sm">
    <header class="row wrap items-center ">
      <div class="text-h5 color-primary">
        {{canal && canal.options ? canal.options.extend_name : canal.name }}
      </div>
    </header>
    <nav>
      <q-tabs inline-label class="text-white shadow-3" :style="`background-color:${color}`">
        <q-route-tab
          name="inicio"
          label="Sobre"
          :to="{ name: 'Inicio', params: { slug: $route.params.slug } }"
          v-if="canal && canal.options && canal.options.has_home"
        />
        <q-route-tab
          name="listar"
          label="Listar"
          :to="{ name: 'Listar', params: { slug: $route.params.slug } }"
        />
        <OrderBy></OrderBy>
        <CategoriasMenu></CategoriasMenu>
        <Filters></Filters>
        
        <q-space />
      </q-tabs>
    </nav>
    
    <transition
      name="custom-classes-transition"
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
      mode="out-in"
    >
      <router-view></router-view>
    </transition>
  </section>
</template>
<script>
import { mapState, mapActions, mapMutations } from "vuex";
import CategoriasMenu from "../components/CategoriasMenu";
import AdvancedSearchForm from "../forms/AdvancedSearchForm";
import Filters from "../components/Filters";
import OrderBy from "../components/OrderBy"

import {
  QTabs,
  QRouteTab,
  QSeparator,
  QSpace,
  QSelect,
  QTab,
  QInput,
  QCard,
  QMenu,
  QList,
  QItem,
  QItemSection,
  ClosePopup,
  QBreadcrumbs,
  QBreadcrumbsEl
} from "quasar";

export default {
  name: "canal",
  directives: { ClosePopup },
  components: {
    QTabs,
    QRouteTab,
    QSeparator,
    QSpace,
    QSelect,
    QInput,
    QTab,
    QCard,
    QMenu,
    QList,
    QItem,
    QItemSection,
    CategoriasMenu,
    AdvancedSearchForm,
    QBreadcrumbs,
    QBreadcrumbsEl,
    Filters,
    OrderBy
  },
  data() {
    return {
      options: [],
      loadingState: false,
      categoryName: ""
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
    goTo() {
      let slug = this.$route.params.slug;
      return `/${slug}/listar`;
    },
    color() {
      return this.canal && this.canal.options
        ? this.canal.options.color
        : "#08275e";
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
          return this.fetchConteudos(query);
          break;
      }
    }
  }
};
</script>
<style lang="stylus" scoped>

</style>
