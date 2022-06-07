<template>
  <section class="q-pa-xs q-pb-lg">
     
    <header class="head q-pa-md">
      
      <h1 class="text-h4 color-primary" v-if="!isLoading">
        {{canal && canal.options ? canal.options.extend_name : canal.name }}
      </h1>
      
      <q-skeleton v-else style="width: 380px; height: 85px" type="text" animation="pulse-x" />
      
    </header>
    
    <q-tabs
      active-bg-color="primary"
      bg-color="lime-5"
      class="bg-primary text-white shadow-2"
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
      <q-card-section>
        <q-badge color="accent" text-color="white" v-if="paginator && !isLoading" v-text="totalCount" />
        <q-skeleton v-else style="width: 300px; height: 13px" type="text" animation="pulse-x"/>
      </q-card-section>
      <q-card-section v-if="$route.params.slug === 'blog'">
        <q-input v-model="term" rounded outlined bottom-slots placeholder="Busca no blog"  :loading="loadingStateSearch">
          <template v-slot:append>
            <q-icon v-if="term !== ''" name="close" @click="term = ''" class="cursor-pointer" />
            <q-icon name="search" class="cursor-pointer" @click="searchInBlog"/>
          </template>
        </q-input>
      </q-card-section>
    </q-card>
    
    <router-view name="canal"></router-view>
    
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
import axios from "axios";

export default {
  props: {
  },
  name: "Canal",
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
      categoryName: "",
      term: "",
      loadingStateSearch: false
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
    },
    async searchInBlog(){
      console.log(this.term)
      const {data} = await axios.get(`/postagens/search/${this.term}`)
      console.log(data)
    }
  }
};
</script>
