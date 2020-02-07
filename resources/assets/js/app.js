import "./bootstrap";
import Vue from "vue";

import VueApexCharts from "vue-apexcharts";
import VuePlyr from "vue-plyr";
import VueRouter from "vue-router";
import routes from "./routes";
import Vuex from "vuex";
import store from "./store/index.js";
import Default from "./layout/Default.vue";
import "./interceptor.js";

Vue.use(VuePlyr, {
  plyr: {
    fullscreen: { enabled: false }
  },
  emit: ["ended"]
});
Vue.use(VueApexCharts);
Vue.use(Vuex);
Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes
});

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - Plataforma Anísio Texeira`;
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // You can use store variable here to access globalError or commit mutation
    if (store.state.isLogged) {
      next();
    } else {
      next("/usuario/login");
    }
  } else {
    next();
  }
});

new Vue({
  router,
  store,
  render: h => h(Default)
}).$mount("#app");
