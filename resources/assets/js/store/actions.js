import client from '../client.js'

const actions = {
    async GET_PAGINATOR({commit}) {
        let response = await client.getDataFromUrl('/conteudos/sites');
        if(response.data.success){
            commit('SET_PAGINATOR', { paginator: response.data.paginator });
        }else{
            commit('SET_MESSAGE',{ message: response.data.message });
        }
    },

};

export default actions;