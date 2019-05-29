import conteudoModel from "./models/conteudo";
import { longStackSupport } from "q";

const actions = {
  async getLayout({ commit }) {
    let resp = await axios("/layout");

    commit("SET_LAYOUT", resp.data.layout.meta_data);
    commit("SET_LINKS", resp.data.links);
  },
  /** APLICATIVOS */
  async fetchAplicativo({ commit }) {
    let resp = await axios.get(`aplicativos/${id}`);
    commit("SET_APLICATIVO", resp.data.aplicativo);
    commit("SET_SHOW_APLICATIVO", true);
    commit("SET_SHOW_CONTEUDO", false);
    commit("SET_NOT_FOUND", false);
  },
  /** CONTEUDOS */
  async fetchConteudos({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    let url = payload.url ? payload.url : `/conteudos?canal=${payload.id}`;
    let resp = await axios.get(url);
    commit("SET_COMPONENT_ID", "");
    if (resp.status == 200 && resp.data.paginator) {
      commit("SET_COMPONENT_ID", "Paginator");
      commit("SET_IS_LOADING", false);
      commit("SET_PAGINATOR", resp.data.paginator);
      
    } else if(resp.status == 200 && resp.data.metadata){
      commit("SET_COMPONENT_ID", "Posts");
      commit("SET_IS_LOADING", false);
      commit("SET_POSTS",resp.data.metadata.blog_posts);
    } 
    else {
      commit("SET_IS_ERROR", true);
    }
  },
  async fetchConteudo({ commit }, payload) {
    let { id } = payload;

    if (id && id != undefined && id != null) {
      let resp = await axios.get(`/conteudos/${id}`);
      if (resp.status == 200 && resp.data) {
        commit("SET_EXIBIR_ID","conteudo");
        commit("SET_CONTEUDO", resp.data.metadata);
      } else {
        commit("SET_EXIBIR_ID","aplicativo");
        commit("SET_APLICATIVO", resp.data.metadata);
      }
      //commit("SET_EXIBIR_ID","notfound");
    } else {
      console.log("reset");
      commit("RESET_OBJECT", { model: conteudoModel, init: "conteudo" });
    }
  },
  async createConteudo({ commit, dispatch }, conteudo) {
    let resp = await axios.post("/conteudos", conteudo);
    console.warn(resp);
    dispatch("showResponse", resp);

    commit("SET_CONTEUDO", resp.data);
  },
  async updateConteudo({ commit, dispatch }, conteudo) {
    let resp = await axios.put(`/conteudos/${conteudo.id}`, conteudo);
    await dispatch("showResponse", resp);

    commit("SET_CONTEUDO", resp.data.conteudo);
  },
  async deleteConteudo({ commit }, id) {
    let resp = await axios.delete(`/conteudos/${id}`);
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
  async login({ commit, dispatch }, user) {
    let resp = await axios.post("/auth/login", user);
    if (resp.status == 200 && resp.data.success) {
      localStorage.setItem("token", resp.data.metadata.token.access_token);
      commit("SET_LOGIN_USER", true);
    } else {
      dispatch("showResponse", resp);
    }
  },
  async logout() {
    let resp = await axios.post("/auth/logout", {
      token: localStorage.token
    });
    console.log(resp);

    //store.commit("LOGOUT_USER");
    //localStorage.removeItem("token");
    //localStorage.removeItem("token");
  },
  async registerUser({ commit, dispatch }, user) {
    let resp = await axios.post(`/auth/register`, user);

    dispatch("showResponse", resp);
  },
  /** CANAIS FOR SELECT */
  async fetchCanaisForSelect({ commit }) {
    let resp = await axios.get("/canais?select");
    commit("SET_CANAIS", resp.data.metadata);
  },
  /** TIPO DE CONTEUDOS */
  async fetchTipos({ commit }) {
    let resp = await axios.get("/tipos");
    commit("SET_TIPOS", resp.data.metadata.tipos);
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
    let resp = await axios.get(`/canais/slug/${slug}`);

    if (resp.status == 200 && resp.data.canal) {
      console.log(resp.data)
      commit("SET_CANAL", resp.data.canal);
      commit("SET_CANAL_ID", resp.data.canal.id);
      commit("SET_SIDEBAR", resp.data.sidebar);
      dispatch("sideBarSet", resp.data.sidebar);
      dispatch("fetchConteudos", { id: resp.data.canal.id });
    } else {
      commit("SET_IS_ERROR", true);
    }
  },
  sideBarSet({commit},sidebar){
    let categories = (sidebar.categories) ? sidebar.categories: null;
      commit("SET_CATEGORIES",categories);
      let temas = (sidebar.temas) ? sidebar.temas : null;
      commit("SET_TEMAS",temas);
      let disciplinas = (sidebar.disciplinas) ? sidebar.disciplinas : null;
      commit("SET_DISCIPLINAS",disciplinas);
      let components = (sidebar.components) ? sidebar.components : null;
      commit("SET_COMPONENTS",components);
      let niveis = (sidebar.niveis) ? sidebar.niveis : null;
      commit("SET_NIVEIS",niveis);
      let tipos = (sidebar.tipos) ? sidebar.tipos : null;
      commit("SET_TIPOS",tipos);
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
