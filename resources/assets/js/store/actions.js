const actions = {
  async getLayout({ commit }) {
    try {
      let resp = await axios("/layout");

      commit("SET_LAYOUT", resp.data.layout.meta_data);
      commit("SET_LINKS", resp.data.links);
      commit("SET_DISCIPLINAS", resp.data.disciplinas);
      commit("SET_TIPOS", resp.data.tipos);
      console.log(resp.data.temas);
      commit("SET_TEMAS", resp.data.temas);
    } catch (e) {
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
    }
  },
  /** APLICATIVOS */
  async fetchAplicativo({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    commit("SET_APLICATIVO", {});
    try {
      await axios.get(`/aplicativos/${payload.id}`).then(resp => {
        commit("SET_EXIBIR_ID", "Aplicativo");
        commit("SET_APLICATIVO", resp.data.metadata);
        commit("SET_IS_LOADING", false);
      });
    } catch (e) {
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
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
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
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
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
    }
  },
  /** WORDPRESS*/
  async fetchPost({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    commit("SET_POST", {});
    try {
      await axios.get(`/posts/${payload.id}`).then(resp => {
        commit("SET_EXIBIR_ID", "Post");
        commit("SET_POST", resp.data.metadata);
        commit("SET_IS_LOADING", false);
      });
    } catch (e) {
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
    }
  },
  /** CONTEUDOS */
  async fetchConteudos({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    //console.log(payload);
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
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
    }
  },
  async fetchConteudo({ commit }, payload) {
    commit("SET_IS_LOADING", true);
    commit("SET_CONTEUDO", {});
    try {
      await axios.get(`/conteudos/${payload.id}`).then(resp => {
        commit("SET_EXIBIR_ID", "Conteudo");
        commit("SET_CONTEUDO", resp.data.metadata);
        commit("SET_IS_LOADING", false);
      });
    } catch (e) {
      commit("SET_EXIBIR_ID", "NotFound");
      commit("SET_IS_LOADING", false);
      commit("SET_IS_ERROR", true);
    }
  },
  async logout({ commit }) {
    try {
      await axios
        .post("/auth/logout", {
          token: localStorage.token
        })
        .then(resp => {
          commit("SET_LOGOUT_USER");
          localStorage.removeItem("token");
        });
    } catch (error) {
      localStorage.removeItem("token");
    }
  },
  /** CANAIS FOR SELECT */
  async fetchCanaisForSelect({ commit }) {
    let resp = await axios.get("/canais?select");
    if (resp.status == 200 && resp.data.success == true) {
      commit("SET_CANAIS", resp.data.metadata);
    }
  },
  /** TIPO DE CONTEUDOS */
  async fetchTiposForSelect({ commit }) {
    let resp = await axios.get("/tipos?select");
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
  async getCanalBySlug({ commit }, slug) {
    try {
      await axios.get(`/canais/slug/${slug}`).then(resp => {
        commit("SET_CANAL", resp.data.metadata);
        commit("SET_CANAL_ID", resp.data.metadata.id);
        localStorage.setItem("canal", resp.data.metadata.id);
      });
    } catch (e) {
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
