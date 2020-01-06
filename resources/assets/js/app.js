import "./bootstrap";
import Vue from "vue";

import VueApexCharts from "vue-apexcharts";

import VueRouter from "vue-router";
import routes from "./routes";
import Vuex from "vuex";
import store from "./store/index.js";
import Main from "./layout/Main.vue";

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
/*
axios.interceptors.response.use(
  response => {
    var status = response.status,
      errors = response.data.errors ? response.data.errors : [],
      message = response.data.message
        ? response.data.message
        : `Erro desconhecido status: ${response.statusText}`,
      isError = response.data.success === true ? false : true;

    if ((isError && status != 200) || (isError && status == 201)) {
      Store.commit("SET_ERRORS", errors);
      Store.commit("SET_IS_ERROR", isError);
      Store.commit("SET_SHOW_MESSAGE", message);
      Store.commit("SET_SHOW_ALERT", true);
    } else if (
      response.data.status == "token_not_found_md" ||
      response.data.status == "invalid_token_md" ||
      response.data.status == "expired_token_md"
    ) {
      Store.commit("SET_IS_ERROR", isError);
      Store.commit("SET_SHOW_MESSAGE", message);
      Store.commit("SET_SHOW_ALERT", true);
    }

    return response;
  },
  error => {
    return Promise.reject(error);
  }
);
*/

new Vue({
  router,
  store,
  render: h => h(Main)
}).$mount("#app");
