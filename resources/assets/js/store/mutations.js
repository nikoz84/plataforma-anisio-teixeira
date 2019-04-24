import state from "./state.js";

const mutations = {
  LOGIN_USER() {
    state.isLogged = true;
  },
  LOGOUT_USER() {
    state.isLogged = false;
  },
  SET_PAGINATOR: paginator => {
    state.paginator = paginator;
  },
  SET_MESSAGE: message => {
    state.message = message;
  },
  SET_CONTEUDO: conteudo => {
    state.conteudo = conteudo;
  },
  SET_CONTEUDOS: conteudos => {
    state.conteudos = conteudos;
  },
  SET_ERRROS: errors => {
    state.errors = errors;
  }
};

export default mutations;
