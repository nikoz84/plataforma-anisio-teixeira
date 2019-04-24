import state from "./state.js";

const mutations = {
  LOGIN_USER(state) {
    state.isLogged = true;
  },
  LOGOUT_USER(state) {
    state.isLogged = false;
  },
  SET_CONTEUDOS(state, paginator) {
    state.paginator = paginator;
  },
  CREATE_CONTEUDO(state, conteudo) {
    state.conteudo.unshift(conteudo);
  },
  DELETE_CONTEUDO(state, conteudo) {
    let index = state.conteudo.findIndex(item => item.id === conteudo.id);
    state.conteudo.splice(index, 1);
  },
  SET_IS_ERROR(state, error) {
    state.error = error;
  },
  SET_CANAL(state, canal) {
    state.canal = canal;
  },
  SET_SIDEBAR(state, sidebar) {
    state.sidebar = sidebar;
  },
  SET_CATEGORIES(state, categories) {
    state.categories = categories;
  },
  SET_TEMAS(state, temas) {
    state.temas = temas;
  },
  SET_DISCIPLINAS(state, disciplinas) {
    state.disciplinas = disciplinas;
  }
};

export default mutations;
