/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import routes from './routes';
import MainApp from './components/MainApp';

Vue.use(VueRouter);
Vue.use(Vuex);


const router = new VueRouter({
    mode: 'history',
    routes,
    //linkActiveClass: "active",
    linkExactActiveClass: "active"
});


router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('token') == null) {
            
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            
           
           
           next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if(localStorage.getItem('token') == null){
            next()
        }
        else{
            next({ name: 'Admin'})
        }
    }else {
        next(); 
    }
  });


new Vue({
    router,
    render: h => h(MainApp)
  }).$mount('#app')