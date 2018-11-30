import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations.js';
import actions from './actions.js';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        isLogged: !!localStorage.getItem('token'),
        userProfile: {},
        paginator: {},
        message: ''
    },
    mutations,
    actions,
    getters: {
        //
    },  
    modules: {
        //
    }
})

export default store;