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
  SET_CONTEUDO(state, newConteudo) {
    state.conteudo = newConteudo;
  },
  CREATE_CONTEUDO(state, conteudo) {
    state.conteudo;
  },
  DELETE_CONTEUDO(state, conteudo) {
    let index = state.conteudo.findIndex(item => item.id === conteudo.id);
    state.conteudo.splice(index, 1);
  },
  SET_IS_ERROR(state, error) {
    state.error = error;
  },
  SET_BUTTON_TEXT(state, buttonText) {
    state.buttonText = buttonText;
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
  },
  SET_CANAL_ID(state, id) {
    state.canalId = id;
  },
  SET_NOT_FOUND(state, notFound) {
    state.notFound = notFound;
  },
  SET_SHOW_CONTEUDO(state, showConteudo) {
    state.showConteudo = showConteudo;
  },
  SET_SHOW_APLICATIVO(state, showAplicativo) {
    state.showAplicativo = showAplicativo;
  },
  SET_ERRORS(state, errors) {
    state.errors = errors;
    state.isError = true;
  },
  SET_SHOW_ALERT(state, showAlert) {
    state.showAlert = showAlert;
  },
  SET_TEXT_ALERT(state, textAlert) {
    state.textAlert = textAlert;
  },
  SET_LICENSES(state, licenses) {
    state.licenses = licenses;
  },
  SET_TIPOS(state, tipos) {
    state.tipos = tipos;
  },
  SET_FORM_DATA(state, formData) {
    state.formData = formData;
  }
};

export default mutations;
