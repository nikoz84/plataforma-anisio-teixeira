/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import routes from './router';
import MainApp from './components/MainApp';

Vue.use(VueRouter);
Vue.use(Vuex);


const router = new VueRouter({
    mode: 'history',
    routes
});


const app = new Vue({
    el: '#app',
    router,
    components:{
        MainApp
    }
});
