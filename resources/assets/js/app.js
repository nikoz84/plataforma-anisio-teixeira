import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import MainApp from "./components/MainApp";
import Vuex from "vuex";
//import 'es6-promise/auto';
import store from "./store/index.js";
import VueLazyload from "vue-lazyload";

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: "/img/fundo-padrao.svg",
  //loading: "dist/loading.gif",
  attempt: 1,
  // the default is ['scroll', 'wheel', 'mousewheel', 'resize', 'animationend', 'transitionend']
  listenEvents: ["scroll"]
});
Vue.use(Vuex);
Vue.use(VueRouter);

require("animate.css/animate.min.css");
require("./bootstrap");

const router = new VueRouter({
  mode: "history",
  routes,
  //linkActiveClass: "active",
  linkExactActiveClass: "active",
  scrollBehavior (to, from, savedPosition) {
    // page scroll to top for all route navigations
    return { x: 0, y: 0 }
  }
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
