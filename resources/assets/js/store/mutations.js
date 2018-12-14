
const mutations = {
    LOGIN_USER (state) {
        state.isLogged = true
    },
    LOGOUT_USER (state) {
        state.isLogged = false
    },
    SET_PAGINATOR: (state, { paginator }) => {
        state.paginator = paginator
    },
    SET_MESSAGE: (state, { message }) => {
        state.message = message
    }
};

export default mutations;