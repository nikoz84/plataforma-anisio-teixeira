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
//import Default from "./layout/Default.vue";
import Main from "./layout/Main.vue";
import "./interceptor.js";
import axios from "axios";


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


Vue.mixin({
  methods: {
    deleteItem(url, id) {
      this.$q.dialog({
        title: 'Confirmar',
        message: 'Realmente deseja apagar esse item?',
        ok: {
          label: 'Sim',
          color: 'negative'
        },
        cancel: {
          label: 'Cancelar',
          color: 'primary'
        },
        persistent: true
      }).onOk(async () => {
        console.log(url)
        console.log(id)
        const resp = await axios.delete(url);

        if(resp.data.success){
          document.getElementById(`item-${id}`).remove();
        }
      })
    }
  },
});

new Vue({
  router,
  store,  
  render: h => h(Main)
}).$mount("#app");
