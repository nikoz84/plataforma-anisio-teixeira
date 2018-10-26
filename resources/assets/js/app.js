import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import MainApp from './components/MainApp';
import store from './store.js';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faCoffee)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false


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
    render: h => h(MainApp)
  }).$mount('#app')