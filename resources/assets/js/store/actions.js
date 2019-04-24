import client from '../client.js'

const actions = {
    async getConteudos({commit}, id) {
        
        let resp = await client.get(`/conteudos?canal=${id}`);
        if(resp.status == 200 && resp.data.paginator){
            commit('SET_CONTEUDOS', resp.data.paginator);
        }else{
            commit('SET_IS_ERROR', true)
        }
        
    },
    async createConteudo({commit}, conteudo) {
        let resp = await client.post('/conteudos', conteudo);
        commit('CREATE_CONTEUDO', resp.data)

    },
    async deleteConteudo({commit}, id){
        let resp = await client.delete(`/conteudos/${id}`);
        commit('DELETE_CONTEUDO', resp.data);
    },
    async getCanal({commit}, url){
        let resp = await client.get(`/canais/slug/${url}` );
        
        if(resp.status == 200 && resp.data.canal){
            commit('SET_CANAL', resp.data.canal)
            commit('SET_SIDEBAR', resp.data.sidebar)
            commit('SET_IS_ERROR', false)
        }else{
            commit('SET_IS_ERROR', true)
        }
    },
    async getEnabledCategories({commit}, params){

        let resp = await client.get('/categories', params);
        console.log(resp)
        if(resp.status == 200 && resp.data){
            commit('SET_CATEGORIES', resp.data.sidebar.categories)
            commit('SET_TEMAS', resp.data.sidebar.temas)
            commit('SET_DISCIPLINAS', resp.data.sidebar.disciplinas)
            commit('SET_COMPONENTES', resp.data.sidebar.componentes)
            commit('SET_NIVEIS', resp.data.sidebar.niveis)
        }else{
            commit('SET_IS_ERROR', true)
        }
    }

};

export default actions;