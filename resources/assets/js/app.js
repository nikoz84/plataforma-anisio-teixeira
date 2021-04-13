// @ts-nocheck
import "./bootstrap";
import Vue from "vue";
import VueCompositionAPI from '@vue/composition-api';
import VueRouter from "vue-router";
import router from "./routes/index.js";
import VueGtag from "vue-gtag";
import VueApexCharts from "vue-apexcharts";
import Vuex from "vuex";
import store from "./store/index.js";
import Default from "./layout/Default.vue";
import "./interceptor.js";


Vue.use(VueGtag, {
  config: { 
    id: process.env.MIX_ANALYTICS,
    params: {
      send_page_view: false
    }
  }
});

Vue.use(VueCompositionAPI);
Vue.use(VueApexCharts);
Vue.use(Vuex);
Vue.use(VueRouter);


new Vue({
  router,
  store,
  
  render: h => h(Default)
}).$mount("#app");
