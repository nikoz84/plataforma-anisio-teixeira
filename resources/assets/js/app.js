import "./bootstrap";
import Vue from "vue";

import VueRouter from "vue-router";
import router from "./routes/index.js";
import VueAnalytics from 'vue-analytics';
import VueApexCharts from "vue-apexcharts";
import Vuex from "vuex";
import store from "./store/index.js";
import Default from "./layout/Default.vue";

import "./interceptor.js";

Vue.use(VueAnalytics, {
  id: process.env.MIX_ANALYTICS,
  router
});
Vue.use(VueApexCharts);
Vue.use(Vuex);
Vue.use(VueRouter);


new Vue({
  router,
  store,
  
  render: h => h(Default)
}).$mount("#app");
