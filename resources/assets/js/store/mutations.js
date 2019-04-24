
const mutations = {
    LOGIN_USER (state) {
        state.isLogged = true
    },
    LOGOUT_USER (state) {
        state.isLogged = false
    },
    SET_CONTEUDOS(state, paginator) {
            return state.paginator = paginator
    },
    CREATE_CONTEUDO(state, conteudo) {
        state.conteudo.unshift(conteudo)
    },
    DELETE_CONTEUDO(state, conteudo){
        let index = state.conteudo.findIndex(item => item.id === conteudo.id)
        state.conteudo.splice(index, 1)
    }
};

export default mutations;