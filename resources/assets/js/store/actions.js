import Http from '../http.js'
const http = new Http;

const actions = {
    async GET_PAGINATOR({commit}) {
        let response = await http.getDataFromUrl('/conteudos/sites');
        if(response.data.success){
            commit('SET_PAGINATOR', { paginator: response.data.paginator })
        }
    },

};

export default actions;