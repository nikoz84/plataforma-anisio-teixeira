import state from "./state.js";

const getters = {
  GET_PAGINATOR(state) {
    return state.paginator;
  },
  GET_MESSAGE(state) {
    return "hola";
  },
  GET_CONTEUDOS(state) {
    return state.response;
  },
  GET_CONTEUDO() {
    return state.response;
  },
  GET_RESPONSE() {
    return "asd";
  }
};

export default getters;
