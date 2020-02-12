import "./bootstrap";
import Vue from "vue";

import VueRouter from "vue-router";
import router from "./router";
import VueApexCharts from "vue-apexcharts";
import VuePlyr from "vue-plyr";
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

new Vue({
  router,
  store,
  render: h => h(Default)
}).$mount("#app");
