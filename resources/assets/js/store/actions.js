import client from "../client.js";
import conteudoModel from "./models/conteudo";

const actions = {
  /** APLICATIVOS */
  async fetchAplicativo({ commit }) {
    let resp = await client.get(`aplicativos/${id}`);
    commit("SET_APLICATIVO", resp.data.aplicativo);
    commit("SET_SHOW_APLICATIVO", true);
    commit("SET_SHOW_CONTEUDO", false);
    commit("SET_NOT_FOUND", false);
  },
  /** CONTEUDOS */
  async fetchConteudos({ commit }, payload) {
    let url = payload.url ? payload.url : `/conteudos?canal=${payload.id}`;
    let resp = await client.get(url);
    if (resp.status == 200 && resp.data.paginator) {
      commit("SET_CONTEUDOS", resp.data.paginator);
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  async fetchConteudo({ commit }, payload) {
    let { id } = payload;

    if (id && id != undefined && id != null) {
      let resp = await client.get(`/conteudos/${id}`);
      if (resp.status == 200 && resp.data) {
        commit("SET_CONTEUDO", resp.data.metadata);
        commit("SET_SHOW_CONTEUDO", true);
        commit("SET_SHOW_APLICATIVO", false);
        commit("SET_NOT_FOUND", false);
      } else {
        //commit("SET_CONTEUDO", {});
        commit("SET_SHOW_CONTEUDO", false);
        commit("SET_SHOW_APLICATIVO", false);
        commit("SET_NOT_FOUND", true);
      }
    } else {
      console.log("reset");
      commit("RESET_OBJECT", { model: conteudoModel, init: "conteudo" });
    }
  },
  async createConteudo({ commit, dispatch }, conteudo) {
    let resp = await client.post("/conteudos", conteudo);
    console.warn(resp);
    dispatch("showResponse", resp);

    commit("SET_CONTEUDO", resp.data);
  },
  async updateConteudo({ commit, dispatch }, conteudo) {
    let resp = await client.put(`/conteudos/${conteudo.id}`, conteudo);
    await dispatch("showResponse", resp);

    commit("SET_CONTEUDO", resp.data.conteudo);
  },
  async deleteConteudo({ commit }, id) {
    let resp = await client.delete(`/conteudos/${id}`);
    commit("DELETE_CONTEUDO", resp.data);
  },
  async showResponse({ commit, dispatch }, response) {
    if (response.status == 201) {
      let errors = response.data.errors ? response.data.errors : [];
      commit("SET_ERRORS", errors);
      commit("SET_SHOW_ALERT", true);
      commit("SET_SHOW_MESSAGE", response.data.message);
      commit("SET_IS_ERROR", true);
    } else if (response.status == 200) {
      commit("SET_ERRORS", []);
      commit("SET_SHOW_ALERT", true);
      commit("SET_SHOW_MESSAGE", response.data.message);
    } else {
      let message = `Erro desconhecido status: ${response.statusText}`;
      commit("SET_SHOW_MESSAGE", message);
      commit("SET_SHOW_ALERT", true);
      commit("SET_IS_ERROR", true);
    }

    dispatch("hideAlert");
  },
  async hideAlert({ commit }) {
    setTimeout(() => {
      commit("SET_SHOW_ALERT", false);
      commit("SET_SHOW_MESSAGE", "");
      commit("SET_IS_ERROR", false);
    }, 2500);
  },
  async goToPage({ commit }, url) {
    console.log(url);
    //if (url) {
    //let resp = await client.get(url);
    //console.log(resp);
    //commit("SET_CONTEUDOS", resp.data);
    //}
  },
  /** CANAIS FOR SELECT */
  async fetchCanaisForSelect({ commit }) {
    let resp = await client.get("/canais?select");
    commit("SET_CANAIS", resp.data.metadata);
  },
  /** TIPO DE CONTEUDOS */
  async fetchTipos({ commit }) {
    let resp = await client.get("/tipos/conteudos");
    commit("SET_TIPOS", resp.data.tipos);
  },
  /** LICENÇAS */
  async fetchLicenses({ commit }) {
    let resp = await client.get("/licenses");
    const data = resp.data.metadata;
    let licenses = data.filter(key => {
      return key.id != 2;
    });
    let childs = data.filter(key => {
      return key.id === 2;
    });
    commit("SET_LICENSES", { licenses, childs });
  },
  /** CANAL */
  async getCanal({ commit, dispatch }, slug) {
    let resp = await client.get(`/canais/slug/${slug}`);

    if (resp.status == 200 && resp.data.canal) {
      commit("SET_CANAL", resp.data.canal);
      commit("SET_CANAL_ID", resp.data.canal.id);
      commit("SET_SIDEBAR", resp.data.sidebar);
      await dispatch("fetchConteudos", { id: resp.data.canal.id });
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  async fetchEnabledCategories({ commit }, params) {
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
    //const formData = new FormData(form);

    Object.keys(form).map(key => {
      console.log(form[key]);
    });
    /*
    Object.keys(form).map(key => {
      if (form.hasOwnProperty(key)) {
        if (key == "options") {
          form.append(`"${key}"`, JSON.stringify(form[key]));
        } else if (key == "image") {
          form.append(`"${key}"`, form[key], "image");
        } else if (key == "file") {
          form.append(`"${key}"`, form[key], "arquivo");
        } else {
          formData.append(`"${key}"`, form[key]);
        }
      }
    }*/
    //commit("SET_FORM_DATA", formData);
    //dispatch("createConteudo", state.formData);
  }
};

export default actions;
