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
        <q-route-tab name="listar" 
              label="Listar" 
              :to="{ name: 'Listar', params: {slug: $route.params.slug}}"/>
        <q-tab label="Categorias" v-if="canal && canal.options && canal.options.has_categories">
          <q-menu anchor="center middle" self="center middle" class="">
            <q-list dense>
              <q-item clickable dense 
                    v-close-popup 
                    v-for="(category, i) in canal.sidebar.categories" 
                    :key="i" 
                    @click="showCategory">
                <q-item-section>{{category.name }}</q-item-section>
                <q-item-section side v-if="category.sub_categories.length > 0">
                  <q-icon name="keyboard_arrow_right" />
                </q-item-section>

                <q-menu anchor="top right" self="top left" v-if="category.sub_categories.length > 0">
                  <q-list dense>
                    <q-item v-for="n in 3" :key="n" clickable>
                      <q-item-section>Submenu Label</q-item-section>
                      <q-item-section side>
                        <q-icon name="keyboard_arrow_right" />
                      </q-item-section>
                    </q-item>
                  </q-list>
                </q-menu>
              </q-item>
            </q-list>
          </q-menu>
        </q-tab>
        <q-space />
        <q-input 
          class="q-mt-md input-search"
          clearable
          filled
          clear-icon="close"
          v-model="termSearch"
          placeholder="Buscar"
          color="red-9"
          bg-color="white"
          dense
          bottom-slots >
          <template v-slot:append>
            <q-btn round dense flat icon="search" @click="search"/>
          </template>
        </q-input>
        <q-space />
        <q-route-tab name="denunciar" 
              label="Denunciar"
              :to="setUrlDenuncia" />
        <q-route-tab name="faleconosco" 
              label="Fale Conosco" 
              :to="setUrlFaleConosco"/>
      </q-tabs>
    </nav>
    <transition name="custom-classes-transition" 
                enter-active-class="animated fadeIn" 
                leave-active-class="animated fadeOut"
                mode="out-in">
      <router-view></router-view>
    </transition>
    
  </article>
  
</template>
<script>
import { mapState, mapActions } from "vuex";
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
    QItemSection
  },
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
    showCategory(id) {
      console.log(id);
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
.input-search {
  min-width: 150px;
}

.page-header {
  text-align: center;

  .page-title {
    position: relative;
    font-size: 20px;
    color: #0f285d;
    font-weight: 700;
  }
}
</style>