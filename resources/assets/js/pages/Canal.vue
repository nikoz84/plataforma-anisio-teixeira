<template>
  <section class="q-px-sm q-pb-sm">
    <header class="row wrap items-center q-my-md">
      <div class="text-h5 color-primary">
        {{canal && canal.options ? canal.options.extend_name : canal.name }}
      </div>
    </header>
    <q-tabs
      :style="`background-color:${color}`" 
      class="text-white shadow-3"
      dense
      shrink
      no-caps
      inline-label
      >
      <CategoriasMenu></CategoriasMenu>
      <Filters></Filters>
      <q-route-tab
        name="listar"
        label="LISTAR"
        :to="{ name: 'Listar', params: { slug: $route.params.slug } }"
      />
      <q-route-tab
        name="busca"
        label="BUSCA AVANÇADA"
        :to="{ name: 'BuscaAvancada' }"
        v-if="$route.params.slug == 'recursos-educacionais'"
      />
      <q-space />
      <OrderBy></OrderBy>
      <q-route-tab
        name="inicio"
        label="SOBRE"
        :to="{ name: 'Inicio', params: { slug: $route.params.slug } }"
        v-if="canal && canal.options && canal.options.has_home"
      />
    </q-tabs>
    <q-card class="q-my-sm q-pl-sm">
      <q-badge color="white" text-color="dark" v-if="paginator" v-text="totalCount" />
    </q-card>
    
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
import  { Filters, OrderBy, CategoriasMenu } from "@components/canais";
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
      this.$ga.page(this.$route.params.slug);
      this.fetchData();
    });
  },
  watch: {
    $route(to, from) {
      if (to.fullPath != from.fullPath) {
        this.$ga.page(this.$route.params.slug);
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
