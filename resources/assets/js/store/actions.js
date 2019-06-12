import conteudoModel from "./models/conteudo";
import { longStackSupport } from "q";

const actions = {
  async getLayout({ commit }) {
    let resp = await axios("/layout");

    commit("SET_LAYOUT", resp.data.layout.meta_data);
    commit("SET_LINKS", resp.data.links);
  },
  /** APLICATIVOS */
  async fetchAplicativo({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    try {
      await axios.get(`aplicativos/${payload.id}`).then(resp => {
        console.log(resp);
        commit("SET_EXIBIR_ID", "Aplicativo");
        commit("SET_APLICATIVO", resp.data.metadata);
        commit("SET_IS_LOADING", false);
      });
    } catch (e) {
      console.log(e);
    }
  },
  async fetchAplicativos({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    try {
      await axios.get(`/aplicativos`, { params: payload }).then(resp => {
        if (resp.status == 200 && resp.data.paginator) {
          commit("SET_COMPONENT_ID", "Paginator");
          commit("SET_IS_LOADING", false);
          commit("SET_PAGINATOR", resp.data.paginator);
        }
      });
    } catch (e) {
      console.log(e);
    }
  },
  /** WORDPRESS*/
  async fetchPosts({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    let url = `/posts`;
    try {
      await axios.get(url, { params: payload }).then(resp => {
        commit("SET_COMPONENT_ID", "");
        if (resp.status == 200 && resp.data.paginator) {
          commit("SET_COMPONENT_ID", "Paginator");
          commit("SET_IS_LOADING", false);
          commit("SET_PAGINATOR", resp.data.paginator);
        }
      });
    } catch (e) {
      commit("SET_IS_ERROR", true);
    }
  },
  /** CONTEUDOS */
  async fetchConteudos({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    let url = `/conteudos`;
    try {
      await axios.get(url, { params: payload }).then(resp => {
        commit("SET_COMPONENT_ID", "");
        if (resp.status == 200 && resp.data.paginator) {
          commit("SET_COMPONENT_ID", "Paginator");
          commit("SET_IS_LOADING", false);
          commit("SET_PAGINATOR", resp.data.paginator);
        }
      });
    } catch (e) {
      commit("SET_IS_ERROR", true);
    }
  },
  async fetchConteudo({ commit }, payload) {
    try {
      await axios.get(`/conteudos/${payload.id}`).then(resp => {
        commit("SET_EXIBIR_ID", "Conteudo");
        commit("SET_CONTEUDO", resp.data.metadata);
      });
    } catch (e) {
      commit("SET_EXIBIR_ID", "NotFound");
    }
  },
  async createConteudo({ commit, dispatch }, conteudo) {
    let resp = await axios.post("/conteudos", conteudo);
    console.warn(resp);
    dispatch("hideAlert");

    commit("SET_CONTEUDO", resp.data);
  },
  async updateConteudo({ commit, dispatch }, conteudo) {
    console.log(conteudo);
    let resp = await axios.put(`/conteudos/${conteudo.id}`, conteudo);
    await dispatch("hideAlert");

    commit("SET_CONTEUDO", resp.data.conteudo);
  },
  async deleteConteudo({ commit }, id) {
    let resp = await axios.delete(`/conteudos/${id}`);
    commit("DELETE_CONTEUDO", resp.data);
  },
  async hideAlert({ commit }) {
    setTimeout(() => {
      commit("SET_SHOW_ALERT", false);
      commit("SET_SHOW_MESSAGE", "");
      commit("SET_IS_ERROR", false);
      commit("SET_ERRORS", []);
    }, 2500);
  },
  async login({ commit, dispatch }, payload) {
    let resp = await axios.post("/auth/login", payload);

    if (resp.status == 200 && resp.data.success) {
      localStorage.setItem("token", resp.data.metadata.token.access_token);
      commit("SET_LOGIN_USER", true);
    } else {
      dispatch("hideAlert");
    }
  },
  async logout({ commit }) {
    if (localStorage.token) {
      await axios.post("/auth/logout", {
        token: localStorage.token
      });
      commit("SET_LOGOUT_USER");
      localStorage.removeItem("token");
    } else {
      commit("SET_LOGOUT_USER");
      localStorage.removeItem("token");
    }
  },
  async registerUser({ commit, dispatch }, user) {
    let resp = await axios.post(`/auth/register`, user);
    if (resp.status == 200 && resp.data.success) {
      commit("SET_IS_ERROR", false);
    } else {
      dispatch("hideAlert");
    }
  },
  /** CANAIS FOR SELECT */
  async fetchCanaisForSelect({ commit }) {
    let resp = await axios.get("/canais?select");
    commit("SET_CANAIS", resp.data.metadata);
  },
  /** TIPO DE CONTEUDOS */
  async fetchTiposForm({ commit }) {
    let resp = await axios.get("/tipos");

    if (resp.status == 200 && resp.data.success == true) {
      commit("SET_TIPOS_FORM", resp.data.metadata);
    }
  },
  /** LICENÇAS */
  async fetchLicenses({ commit }) {
    let resp = await axios.get("/licenses?select");
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
  async getCanalBySlug({ commit, dispatch }, slug) {
    try {
      await axios.get(`/canais/slug/${slug}`).then(resp => {
        commit("SET_CANAL", resp.data.canal);
        commit("SET_CANAL_ID", resp.data.canal.id);
        localStorage.setItem("canal", resp.data.canal.id);
        commit("SET_SIDEBAR", resp.data.sidebar);
        dispatch("sideBarSet", resp.data.sidebar);
      });
    } catch (e) {
      commit("SET_IS_ERROR", true);
    }
  },
  sideBarSet({ commit }, sidebar) {
    let categories = sidebar.categories ? sidebar.categories : null;
    commit("SET_CATEGORIES", categories);
    let temas = sidebar.temas ? sidebar.temas : null;
    commit("SET_TEMAS", temas);
    let disciplinas = sidebar.disciplinas ? sidebar.disciplinas : null;
    commit("SET_DISCIPLINAS", disciplinas);
    let components = sidebar.components ? sidebar.components : null;
    commit("SET_COMPONENTS", components);
    let niveis = sidebar.niveis ? sidebar.niveis : null;
    commit("SET_NIVEIS", niveis);
    let tipos = sidebar.tipos ? sidebar.tipos : null;
    commit("SET_TIPOS", tipos);
    //let licenses = (sidebar.licenses) ? sidebar.licenses : null;
    //commit("SET_LICENSES",licenses)
  },
  async fetchEnabledCategories({ commit }, params) {
    let resp = await axios.get("/categories", params);

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
  }
};

export default actions;
