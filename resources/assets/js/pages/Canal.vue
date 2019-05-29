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
import { mapState, mapActions } from "vuex";

export default {
  name: "canal",
  components: { NavCanal, sidebar: SidebarCanal },
  mounted() {
    this.getCanalBySlug(this.$route.params.slug);
  },
  watch: {
    $route(to, from) {
     
     if(to.fullPath != from.fullPath){
       this.getCanalBySlug(this.$route.params.slug);
     }
     //
    }
  },
  methods: {
    ...mapActions(["getCanalBySlug"]),
  },
  computed: {
    ...mapState(["canal"])
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