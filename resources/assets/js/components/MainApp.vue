<template>
    <main>
        <nav-principal></nav-principal>
        {{viewport}}
        <router-view></router-view>
        <footer-app></footer-app>
        <side-bar></side-bar>
        <back-to-top></back-to-top>
        <icon-bar></icon-bar>
    </main>
</template>

<script>
import NavPrincipal from "./NavPrincipal.vue";
import FooterApp from "./FooterApp.vue";
import BackToTop from "./BackToTop.vue";
import IconBar from "./IconBar.vue";
import SideBar from "./SideBar.vue";
import { mapState, mapActions, mapMutations } from "vuex";

export default {
  name: "main-app",
  components: {
    "nav-principal": NavPrincipal,
    "footer-app": FooterApp,
    "back-to-top": BackToTop,
    "side-bar": SideBar,
    "icon-bar": IconBar
  },
  mounted() {},
  created() {
    window.addEventListener("resize", this.handleResize);

    this.handleResize();
    this.getLayout();
  },
  computed: {
    ...mapState(["layout", "viewport"])
  },
  methods: {
    ...mapActions(["getLayout"]),
    ...mapMutations(["SET_VIEWPORT"]),
    handleResize() {
      let width = window.innerWidth,
        heigth = window.innerHeight;

      this.SET_VIEWPORT({ width, heigth });
    }
  },
  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  }
};
</script>
<style lang="scss" >
$black: #000;
$white: #fff;
$primary: #fff;

body {
  padding-top: 60px;
}

.heigth {
  min-height: 100vh;
}
.tag-cloud {
  a {
    text-transform: uppercase;
    display: inline-block;
    padding: 4px 10px;
    margin-bottom: 7px;
    margin-right: 4px;
    border-radius: 4px;
    text-decoration: none;
    color: $black;
    border: 1px solid #ccc;
    font-size: 15px;
    &:hover {
      border: 1px solid $black;
    }
  }
}

.pointer {
  cursor: pointer;
}
.break-word {
  word-wrap: break-word;
}
.tag {
  margin-right: 10px;
  margin-bottom: 5px;
}
.label {
  padding: 6px;
  margin-right: 15px;
  margin-bottom: 10px;
}

hr.line {
  border: 0;
  height: 1px;
  background: #333;
  background-image: linear-gradient(to right, #ccc, #949da5, #ccc);
}

hr {
  border: 1px solid rgb(235, 234, 234);
}
.justify-content-center {
  -webkit-box-pack: center !important;
  -ms-flex-pack: center !important;
  justify-content: center !important;
}

.menu_admin {
  list-style-type: none;
  background: rgb(243, 243, 243);
  margin-bottom: 5px;
  padding: 5px;
}

.menu_admin a:link,
a:visited {
  text-decoration: none;
}

/* Hide all steps by default: 
.tab {
  display: none;
}
*/

/* Make circles that indicate the steps of the form: 
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}
*/
/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4caf50;
}
</style>