import client from "../client.js";

const actions = {
  async FETCH_CONTEUDO({ commit }, id) {
    console.log(id);
    let response = await client.get(`/conteudos/${id}`);
    console.log(response);
    commit("SET_CONTEUDO", response.data);
  },
  async FETCH_CONTEUDOS({ commit }) {
    let response = await client.get(`/conteudos`);
    if (response.data.success) {
      commit("SET_CONTEUDOS", response.data);
    } else {
      commit("SET_CONTEUDOS", response.data.errors);
    }
  }
};

export default actions;
