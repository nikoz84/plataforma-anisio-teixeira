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
Vue.prototype.$formvuelar = {
  noResultsText: "No results found!",
  pleaseWaitText: "Please wait...",
  addFileText: "Add File",
  addFilesText: "Add Files",
  filesSelectedText: "Files Selected",
  dropFilesHereText: "Drop files here or click to upload.",
  filesSelectedAndSizeText: "files selected with a combined size of",
  headers: "{}"
};
require("animate.css/animate.min.css");
require("./bootstrap");

const router = new VueRouter({
  mode: "history",
  routes,
  //linkActiveClass: "active",
  linkExactActiveClass: "active"
});

/*
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {

        if ( localStorage.getItem('token') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if(localStorage.getItem('token') == null){
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        }
        else{
            next({ name: 'Admin'})
        }
    }else {
        next();
    }
  });
*/

new Vue({
  router,
  store,
  render: h => h(MainApp)
}).$mount("#app");
