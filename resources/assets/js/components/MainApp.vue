<template>
    <main>
        <nav-app></nav-app>
        <router-view></router-view>
        <footer-app></footer-app>
    </main>
</template>

<script>
import NavApp from "./NavComponent.vue";
import FooterApp from "./FooterComponent.vue";

export default {
  name: "main-app",
  components: {
    NavApp,
    FooterApp
  },
  methods: {}
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
