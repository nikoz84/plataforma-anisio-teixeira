import client from '../client.js'

const actions = {
    async getConteudos({commit}, id) {
        
        let resp = await client.get(`/conteudos?canal=${id}`);

        commit('SET_CONTEUDOS', resp.data.paginator)
    },
    async createConteudo({commit}, conteudo) {
        let resp = await client.post('/conteudos', conteudo);
        commit('CREATE_CONTEUDO', resp.data)

    },
    async deleteConteudo({commit}, id){
        let resp = await client.delete(`/conteudos/${id}`);
        commit('DELETE_CONTEUDO', resp.data);
    }

};

export default actions;