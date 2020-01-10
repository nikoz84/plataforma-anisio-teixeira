<template>
  <section class="q-pa-md">
    <!--Breadcrum></Breadcrum-->
    <header class="row justify-center">
      <div class="text-h5 title-page" :style="`color:${color}`">
        {{ canal && canal.options ? canal.options.extend_name : "" }}
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
        <CategoriasMenu
          :categoryName="categoryName"
          :categories="canal.sidebar.categories"
          v-if="canal.sidebar"
        ></CategoriasMenu>
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
import CategoriasMenu from "../components/CategoriasMenu.vue";
import AdvancedSearchForm from "../forms/AdvancedSearchForm.vue";
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
  ClosePopup
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
    AdvancedSearchForm
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
          this.categoryName = "Categorias";
          return this.fetchAplicativos(query);
          break;
        case localStorage.canal == 7:
          return this.fetchPosts();
          break;
        case localStorage.canal == 1:
        case localStorage.canal == 12:
          this.categoryName = "Programas";
          return this.fetchConteudos(query);
          break;
        case localStorage.canal == 2:
          this.categoryName = "Níveis de Ensino";
          return this.fetchConteudos(query);
          break;
        case localStorage.canal == 3:
          this.categoryName = "Projetos";
          return this.fetchConteudos(query);
          break;

        default:
          this.categoryName = "";
          return this.fetchConteudos(query);
          break;
      }
    }
  }
};
</script>
<style lang="stylus" scoped>
.input-search {
  min-width: 350px;
}
</style>
