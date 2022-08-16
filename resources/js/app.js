
import "./bootstrap";
import Vue from "vue";
import VueRouter from "vue-router";
import router from "./routes/index.js";
import VueGtag from "vue-gtag";
import VueApexCharts from "vue-apexcharts";
import Vuex from "vuex";
import store from "./store/index.js";
import Main from "./layout/Main.vue";
import "./interceptor.js";

import Quasar from "quasar";
//import anime from 'animejs/lib/anime.min.js';
import {
  Meta,
  Notify,
  Loading,
  Dialog,
  Dark,
  Platform,
  LocalStorage,
  AppFullscreen,
  QSpinnerGears
} from "quasar";
import "quasar/dist/quasar.ie.polyfills.umd.min.js";
import langPT from "quasar/lang/pt-br.js";
import iconSet from "quasar/dist/icon-set/material-icons.umd.min.js";
import "@quasar/extras/material-icons/material-icons.css";
//import QPlayer from '@quasar/quasar-ui-qmediaplayer'
//import '@quasar/quasar-ui-qmediaplayer/dist/index.css'
import "~@/app.styl"

Loading.setDefaults({
  spinner: QSpinnerGears,
});

//Vue.prototype.$anime = anime;
//Vue.use(QPlayer, {lang: 'pt-BR'});
Vue.use(Quasar, {
  lang: langPT,
  iconSet: iconSet,
  plugins: {
    Meta,
    Notify,
    Loading,
    Dialog,
    Dark,
    Platform,
    LocalStorage,
    AppFullscreen,
  },
  extras: [
    'roboto-font',
    'material-icons'
  ]
});






Vue.use(VueGtag, {
  config: { 
    id: import.meta.env.VITE_ANALYTICS,
    params: {
      send_page_view: false,
      cookie_flags: "SameSite=None;Secure"
    },
    
  }
});

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
        const resp = await this.axios.delete(url);
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
