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
<style lang="scss" scoped>
/*
.scrollmenu {
  overflow: auto;
  white-space: nowrap;
  display: flex;
  overflow-x: scroll;
  overflow-y: hidden;
  -webkit-overflow-scrolling: touch;
  -ms-overflow-style: -ms-autohiding-scrollbar;
  > li {
    flex: 0 0 auto;
    padding-top: 15px;
    padding-bottom: 15px;
  }
  > li::after {
    content: " | ";
    padding: 0 20px;
  }
  > li:first-child {
    padding-left: 15px;
  }
  margin-bottom: 5vh;
}
.scrollmenu::-webkit-scrollbar {
  display: none;
}
*/
ul {
  margin: 5px;
}

li {
  border: 1px solid rgb(231, 230, 230);
  background-color: rgb(233, 233, 233);
}

.title {
  background-color: rgb(131, 133, 134);
  color: rgb(255, 255, 255);
  padding: 10px;
  font-weight: bold;
}
</style>