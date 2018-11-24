import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import MainApp from './components/MainApp';
<<<<<<< HEAD
import Vuex from 'vuex';
import 'es6-promise/auto';
import store from './store/index.js';

=======
import store from './store.js';
>>>>>>> 8f2cfa56bbd2e9f6d3b8e96aba7a5395cb7a36f2

Vue.use(Vuex);
Vue.use(VueRouter);

require('animate.css/animate.min.css');
require('./bootstrap');


const router = new VueRouter({
    mode: 'history',
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
  }).$mount('#app')