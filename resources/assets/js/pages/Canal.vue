<template>
    <section class="container-fluid heigth">
        <div class="row">
            <aside class="col-sm-3">
                <sidebar></sidebar>
            </aside>
            <article class="col-sm-9">
                <!--Breadcrum></Breadcrum-->
                <header class="page-header">
                    <h1 class="page-title">
                        {{ canal.name }}
                    </h1>
                    <NavCanal></NavCanal>
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
        </div>
    </section>
</template>
<script>
import NavCanal from "../components/NavCanal.vue";
import SidebarCanal from "../components/SidebarCanal.vue";
//import Breadcrum from "../components/Breadcrum.vue";
import debounce from "lodash/debounce";
import { mapState, mapActions } from "vuex";

export default {
  name: "canal",
  components: { NavCanal, sidebar: SidebarCanal },
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
  },
  computed: {
    ...mapState(["canal"])
  }
};
</script>
<style lang="scss" scoped>
$downriver-900: #051825; /* 900 */
$downriver-800: #0f285d; /* 800 */
$downriver-700: #263c6c; /* 700 */
$downriver-600: #42537f; /* 600 */
$downriver-400: #5f6a93; /* 400 */
$downriver-300: #7f87a9; /* 300 */
$downriver-200: #a0a4bf; /* 200 */
$downriver-80: #c1c3d5; /* 80 */
$downriver-50: #d9d9e5; /* 50 */
$downriver-20: #f0f0f5; /* 20 */

.page-header {
  margin: 0;
}

.page-header .page-title {
  margin-top: 0;
  position: relative;
  margin-bottom: 30px;
  color: $downriver-800;
}
.page-header .page-title:after {
  width: 25%;
  height: 2px;
  content: "";
  background: $downriver-700;
  display: block;
  position: absolute;
  bottom: -10px;
}

aside > header > h3 {
  margin-top: 5px;
  font-size: 18px;
}
</style>