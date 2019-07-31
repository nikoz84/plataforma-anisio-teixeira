import "./bootstrap";
import Vue from "vue";

import Quasar from "quasar/dist/quasar.umd.min.js";
import "quasar/dist/quasar.ie.polyfills";
import lang from "quasar/lang/pt-br.js";
import materialIcons from "quasar/dist/icon-set/material-icons.umd.min.js";
import "quasar-extras/roboto-font/roboto-font.css";
import "quasar-extras/material-icons/material-icons.css";

import VueRouter from "vue-router";
import routes from "./routes";
import Main from "./layout/Main.vue";
import Vuex from "vuex";
import store from "./store/index.js";

Quasar.lang.set(lang);

Vue.use(Quasar, {
  iconSet: materialIcons
});
Vue.use(Vuex);
Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes
});

router.beforeEach((to, from, next) => {
  document.title = `Plataforma Anísio Texeira - ${to.meta.title}`;
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
