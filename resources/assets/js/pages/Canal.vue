<template>
    <section class="container-fluid heigth">
        <div class="row">
            <aside class="col-sm-3">
                <sidebar></sidebar>
            </aside>
            <article class="col-sm-9">
                <Breadcrum></Breadcrum>
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
import NavCanal from "../components/NavCanalComponent.vue";
import SidebarCanal from "../components/SidebarCanalComponent.vue";
import Breadcrum from "../components/BreadcrumComponent.vue";
import client from "../client.js";
import { mapState } from "vuex";

export default {
  name: "canal",
  components: { NavCanal, sidebar: SidebarCanal, Breadcrum },
  mounted() {
    this.getFromSlug();
  },
  watch: {
    $route(to, from) {
      this.getFromSlug();
    }
  },
  methods: {
    getFromSlug() {
      this.$store.dispatch("getCanal", `${this.$route.params.slug}`);
    }
  },
  computed: {
    canal() {
      return this.$store.state.canal;
    }
  }
};
</script>
<style lang="scss" scoped>
.page-header {
  margin: 0;
}

.page-header .page-title {
  margin-top: 0;
  position: relative;
  margin-bottom: 30px;
}
.page-header .page-title:after {
  width: 15%;
  height: 2px;
  content: "";
  background: var(--color);
  display: block;
  position: absolute;
  bottom: -10px;
}

aside > header > h3 {
  margin-top: 5px;
  font-size: 18px;
}
</style>