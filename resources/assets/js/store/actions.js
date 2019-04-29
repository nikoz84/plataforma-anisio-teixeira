import client from "../client.js";

const actions = {
  /** APLICATIVOS */
  async getAplicativo({ commit }) {
    let resp = await client.get(`aplicativos/${id}`);
    commit("SET_APLICATIVO", resp.data.aplicativo);
    commit("SET_SHOW_APLICATIVO", true);
    commit("SET_SHOW_CONTEUDO", false);
    commit("SET_NOT_FOUND", false);
  },
  /** CONTEUDOS */
  async getConteudos({ commit }, payload) {
    let url = payload.url ? payload.url : `/conteudos?canal=${payload.id}`;
    let resp = await client.get(url);
    if (resp.status == 200 && resp.data.paginator) {
      commit("SET_CONTEUDOS", resp.data.paginator);
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  async getConteudo({ commit }, { slug, id }) {
    let resp = await client.get(`/conteudos/${id}`);
    if(resp.status == 200){
        commit("SET_CONTEUDO", resp.data.conteudo);
        commit("SET_SHOW_CONTEUDO", true);
        commit("SET_SHOW_APLICATIVO", false);
        commit("SET_NOT_FOUND", false);
    }else{
        commit("SET_SHOW_CONTEUDO", false);
        commit("SET_SHOW_APLICATIVO", false);
        commit("SET_NOT_FOUND", true);
    }
  },
  async createConteudo({ commit }, conteudo) {
    let resp = await client.post("/conteudos", conteudo);

    if (resp.data) {
      commit("SET_ERRORS", resp.data.errors);
      commit("SET_SHOW_ALERT", true);
      commit("SET_TEXT_ALERT", resp.data.message);
      commit("SET_IS_ERROR", true);
    }

    console.log(resp);
    //commit("CREATE_CONTEUDO", resp.data);
  },
  async updateConteudo({ commit }, conteudo) {
    let resp = await client.put(`/conteudos/${conteudo.id}`, conteudo);
    console.log(resp)
    if (resp.status == 200 && resp.data.success == true) {
      commit("SET_ERRORS", resp.data.errors);
      commit("SET_SHOW_ALERT", true);
      commit("SET_TEXT_ALERT", resp.data.message);
      commit("SET_IS_ERROR", false);
    }

    console.log(resp);
    
  },
  async deleteConteudo({ commit }, id) {
    let resp = await client.delete(`/conteudos/${id}`);
    commit("DELETE_CONTEUDO", resp.data);
  },
  async getTipos({ commit }) {
    let resp = await client.get("/tipos/conteudos");
    commit("SET_TIPOS", resp.data.tipos);
  },
  async getLicenses({ commit }) {
    let resp = await client.get("/licenses");
    //console.log(resp.data)
    commit("SET_LICENSES", resp.data.paginator.data);
  },
  async getCanal({ commit, dispatch }, slug) {
    let resp = await client.get(`/canais/slug/${slug}`);

    if (resp.status == 200 && resp.data.canal) {
      commit("SET_CANAL", resp.data.canal);
      commit("SET_CANAL_ID", resp.data.canal.id);
      commit("SET_SIDEBAR", resp.data.sidebar);
      commit("SET_IS_ERROR", false);
      await dispatch("getConteudos", { id: resp.data.canal.id });
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  async getEnabledCategories({ commit }, params) {
    let resp = await client.get("/categories", params);

    if (resp.status == 200 && resp.data) {
      commit("SET_CATEGORIES", resp.data.sidebar.categories);
      commit("SET_TEMAS", resp.data.sidebar.temas);
      commit("SET_DISCIPLINAS", resp.data.sidebar.disciplinas);
      commit("SET_COMPONENTES", resp.data.sidebar.componentes);
      commit("SET_NIVEIS", resp.data.sidebar.niveis);
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  showExibir({ commit }, slug) {
    if (slug != "aplicativos-educacionais") {
      commit("SET_SHOW_CONTEUDO", true);
      commit("SET_SHOW_APLICATIVO", false);
    } else {
      commit("SET_SHOW_CONTEUDO", false);
      commit("SET_SHOW_APLICATIVO", true);
    }
  },
  serializeFormData({ commit, dispatch, state }, form) {
    const formData = new FormData(form);

    Object.keys(form).map(key => {
      if (form.hasOwnProperty(key)) {
        if (key == "options") {
          form.append(`"${key}"`, JSON.stringify(form[key]));
        } else if (key == "image") {
          form.append(`"${key}"`, form[key]);
        } else {
          formData.append(`"${key}"`, form[key]);
        }
      }
    });
    commit("SET_FORM_DATA", formData);
    dispatch("createConteudo", state.formData);
  }
};

export default actions;
