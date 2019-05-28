import { updateField } from "vuex-map-fields";

const mutations = {
  updateField,
  SET_LAYOUT(state, layout) {
    state.layout = layout;
  },
  SET_LINKS(state, links) {
    state.links = links;
  },
  SET_LOGIN_USER(state) {
    state.isLogged = true;
  },
  SET_LOGOUT_USER(state) {
    state.isLogged = false;
  },
  SET_POSTS(state, posts) {
    state.posts = posts;
  },
  SET_COMPONENT_ID(state,componentId){
    state.componentId = componentId;
  },
  SET_EXIBIR_ID(state,exibirId){
    state.exibirId = exibirId;
  },
  SET_IS_LOADING(state, isLoading){
    state.isLoading = isLoading
  },
  SET_HOME_DATA(state, homeData){
    state.homeData = homeData;
  },
  SET_PAGINATOR(state, paginator){
    state.paginator = paginator;
  },
  SET_CONTEUDOS(state, conteudos) {
    state.conteudos = conteudos;
  },
  SET_CONTEUDO(state, newConteudo) {
    state.conteudo = newConteudo;
  },
  CREATE_CONTEUDO(state, newConteudo) {
    state.conteudo = newConteudo;
  },
  DELETE_CONTEUDO(state, conteudo) {
    //let index = state.conteudo.findIndex(item => item.id === conteudo.id);
    //state.conteudo.splice(index, 1);
  },
  SET_IS_ERROR(state, isError) {
    state.isError = isError;
  },
  SET_REDIRECT(state, redirect) {
    state.redirect = redirect;
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
  SET_COMPONENTS(state, components) {
    state.components = components;
  },
  SET_NIVEIS(state, niveis) {
    state.niveis = niveis;
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
  RESET_OBJECT(state, data) {
    const { model, init } = data;

    let obj = state[init];
    if (obj && obj != "undefined" && obj != null) {
      Object.keys(obj).map(key => {
        if (model.hasOwnProperty(key)) {
          if (key == "options") {
            obj[key] = Object.assign({}, model[key]);
          } else {
            obj[key] = model[key];
          }
        } else {
          delete obj[key];
        }
      });
    }

    state[init] = Object.assign({}, obj);
  },
  SET_ERRORS(state, errors) {
    state.errors = errors;
  },
  SET_SHOW_MESSAGE(state, textAlert) {
    state.textAlert = textAlert;
  },
  SET_SHOW_ALERT(state, showAlert) {
    state.showAlert = showAlert;
  },
  SET_LICENSES(state, { licenses, childs }) {
    state.licenses = licenses;
    state.childsLicenses = childs[0].childs;
  },
  SET_TIPOS(state, tipos) {
    state.tipos = tipos;
  },
  SET_FORM_DATA(state, formData) {
    state.formData = formData;
  },
  SET_CANAIS(state, canais) {
    state.canais = canais;
  }
};

export default mutations;
