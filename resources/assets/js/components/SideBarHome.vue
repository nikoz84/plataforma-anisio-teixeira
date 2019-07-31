<template>
  <nav>
    <div class="title" role="presentation">Canais</div>
    <ul :class="setClass">
      <router-link v-for="(link,i) in links"
              :key="i"
              tag="li"
              class="swipable"
              :to="{ name: 'Listar', params: { slug: link.slug }}">
          <a>{{link.name}}</a>
      </router-link>
    </ul>
    <div class="clearfix"></div>
  </nav>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "SideBarHome",
  computed: {
    ...mapState(["links", "viewport"]),
    setClass() {
      console.log(this.viewport.width);
      return this.viewport.width > 1024
        ? "nav nav-pills nav-stacked"
        : "scrollmenu list-inline";
    },
    setVerticalClass() {}
  },
  mounted() {
    if (this.viewport.width > 1024) {
      window.addEventListener("touchstart", this.handleTouch);
    }

    this.handleTouch();
  },
  methods: {
    handleTouch() {
      let swipableElement = document.querySelector(".swipable");

      if (swipableElement) {
        console.log("touch");
      }
    }
  },
  destroyed() {
    window.removeEventListener("touchend", this.handleTouch);
  }
};
</script>
<style lang="stylus" scoped>

</style>