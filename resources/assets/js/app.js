import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import MainApp from "./components/MainApp";
import Vuex from "vuex";
//import 'es6-promise/auto';
import store from "./store/index.js";
import VueTinyLazyloadImg from "vue-tiny-lazyload-img";

Vue.use(VueTinyLazyloadImg);
Vue.use(Vuex);
Vue.use(VueRouter);

require("animate.css/animate.min.css");
require("./bootstrap");

const router = new VueRouter({
  mode: "history",
  routes,
  //linkActiveClass: "active",
  linkExactActiveClass: "active"
});

router.beforeEach((to, from, next) => {
  document.title = `Plataforma Anísio Texeira - ${to.meta.title}`;
  next();
});

window.Store = store;
/*
Router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // You can use store variable here to access globalError or commit mutation
    next("/Login");
  } else {
    next();
  }
});
*/
new Vue({
  router,
  store,
  render: h => h(MainApp)
}).$mount("#app");
