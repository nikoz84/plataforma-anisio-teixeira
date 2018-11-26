
const mutations = {
    LOGIN_USER (state) {
        state.isLogged = true
    },
    LOGOUT_USER (state) {
        state.isLogged = false
    },
    SET_PAGINATOR: (state, { paginator }) => {
        state.paginator = paginator
    }
};

export default mutations;