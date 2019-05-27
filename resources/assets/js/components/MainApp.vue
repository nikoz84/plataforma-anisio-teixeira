<template>
    <main>
        <nav-principal></nav-principal>
        <router-view></router-view>
        <footer-app></footer-app>
        <side-bar></side-bar>
        <back-to-top></back-to-top>
        <open-side-bar></open-side-bar>
    </main>
</template>

<script>
import NavPrincipal from "./NavPrincipal.vue";
import FooterApp from "./FooterApp.vue";
import BackToTop from "./BackToTop.vue";
import OpenSideBar from "./OpenSideBar.vue";
import SideBar from "./SideBar.vue";
import { mapActions, mapState } from "vuex";

export default {
  name: "main-app",
  components: {
    "nav-principal": NavPrincipal,
    "footer-app": FooterApp,
    "back-to-top": BackToTop,
    "side-bar": SideBar,
    "open-side-bar": OpenSideBar
  },
  mount() {
    this.getLayout();
  },
  computed: {
    ...mapState(["layout"])
  },
  methods: {
    ...mapActions(["getLayout"])
  }
};
</script>
<style lang="scss" >
body {
  padding-top: 60px;
}
.heigth {
  min-height: 80vh;
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

.glyphicon-asterisk {
  color: rgb(128, 3, 3);
  font-size: 19px;
  margin-left: 5px;
}

small {
  font-size: 90%;
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

/* checkbox */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.container .container-text {
  margin-left: 10px;
}

.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  text-align: left;
}

.container:hover input ~ .checkmark {
  background-color: #ccc;
}

.container input:checked ~ .checkmark {
  background-color: #2196f3;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.container input:checked ~ .checkmark:after {
  display: block;
}

.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>