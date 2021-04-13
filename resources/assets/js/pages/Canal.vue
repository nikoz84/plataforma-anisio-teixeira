<template>
  <section class="q-pa-xs q-pb-lg">
    <q-banner class="bg-grey-4">  
      <header class="q-my-md q-gutter-md">
        <div class="text-h5 color-primary" v-if="!isLoading">
          {{canal && canal.options ? canal.options.extend_name : canal.name }}
        </div>
        <div v-else>
          <q-skeleton style="width: 300px; height: 25px" type="text" animation="pulse-x" />
        </div>
      </header>
    </q-banner>
    <q-tabs
      :style="`background-color:${color}`" 
      class="text-white shadow-3"
      no-caps
      ripple
      dense
      inline-label
      >
      <CategoriasMenu></CategoriasMenu>
      <Filters></Filters>
      <q-route-tab
        name="listar"
        label="LISTAR"
        icon="view_list"
        :to="{ name: 'Listar', params: { slug: $route.params.slug } }"
      />
      <OrderBy></OrderBy>
      <q-space />
      <q-route-tab
        name="busca"
        label="BUSCA AVANÇADA"
        icon="search"
        :to="{ name: 'BuscaAvancada' }"
        v-if="$route.params.slug == 'recursos-educacionais'"
      />
      <q-route-tab
        name="inicio"
        label="SOBRE"
        icon="info"
        :to="{ name: 'Inicio', params: { slug: $route.params.slug } }"
        v-if="canal && canal.options && canal.options.has_home"
      />
    </q-tabs>
    <q-card class="q-my-sm q-pl-sm">
      <q-badge color="white" text-color="dark" v-if="paginator && !isLoading" v-text="totalCount" />
      <q-skeleton v-else style="width: 300px; height: 13px" type="text" animation="pulse-x"/>
    </q-card>
    
    <router-view></router-view>
    
  </section>
</template>
<script>// @ts-nocheck
import { mapState, mapActions, mapMutations } from "vuex";
import  { Filters, OrderBy, CategoriasMenu } from "../components/canais";
import {
  QTabs,
  QTab,
  QRouteTab,
  QSeparator,
  QSpace,
  QSelect,
  QInput,
  QCard,
  QMenu,
  QList,
  QItem,
  QBadge,
  QItemSection,
  ClosePopup,
  QBreadcrumbs,
  QBreadcrumbsEl,
  QSkeleton,
  QBanner
} from "quasar";

export default {
  name: "canal",
  directives: { ClosePopup },
  components: {
    QTabs,
    QBanner,
    QBadge,
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
    QBreadcrumbs,
    QBreadcrumbsEl,
    QSkeleton,
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
      this.$gtag.pageview(this.$route.params.slug);
      this.fetchData();
    });
  },
  watch: {
    $route(to, from) {
      if (to.fullPath != from.fullPath) {
        
        this.$gtag.pageview(this.$route.params.slug);
    
        this.getCanalBySlug(this.$route.params.slug).then(() => {
          this.fetchData();
        });
      }
    }
  },
  computed: {
    ...mapState(["canal", "paginator", "isLoading"]),
    goTo() {
      let slug = this.$route.params.slug;
      return `/${slug}/listar`;
    },
    color() {
      return this.canal && this.canal.options
        ? this.canal.options.color
        : "#08275e";
    },
    totalCount() {
      return this.isLoading ? 'carregando' : `${this.paginator.total} - itens encontrados`;
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
<style lang="stylus">
$text-color = #004081
$background-cinza = #e1e2e1

.q-tabs__arrow--right {
  top: 0;
  right: 0;
  bottom: 0;
  color: $text-color;
  background-color: $background-cinza !important;
}
.q-tabs__arrow--left {
  top: 0;
  right: 0;
  bottom: 0;
  color: $text-color;
  background-color: $background-cinza !important;
}
.q-tabs__arrow--faded {
  display: none;
}

</style>
