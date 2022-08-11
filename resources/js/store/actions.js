
const actions = {
  async getLayout({ commit }) {
    try {
      let resp = await axios("/layout");

      commit("SET_LAYOUT", resp.data.layout.meta_data);
      commit("SET_LINKS", resp.data.links);
      commit("SET_TIPOS", resp.data.tipos);
      commit("SET_LICENCAS", resp.data.licencas);
      commit("SET_COMPONENTES", resp.data.componentes);
      commit("SET_NIVEIS", resp.data.niveis);
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
      const resp = await axios.get(url, { params: payload })
        commit("SET_COMPONENT_ID", "");
        if (resp.status == 200 && resp.data.paginator) {
          commit("SET_COMPONENT_ID", "Paginator");
          commit("SET_IS_LOADING", false);
          commit("SET_PAGINATOR", resp.data.paginator);
        }
      
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
    let token  = localStorage.token;
    try {
      await axios
        .post(`/auth/logout?token=${token}`)
        .then(resp => {
          console.log(resp.data);
          commit("SET_LOGOUT_USER");
          localStorage.removeItem("token");
          localStorage.removeItem("user");
          localStorage.removeItem("linksAdmin");
        });
    } catch (error) {
      commit("SET_LOGOUT_USER");
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      localStorage.removeItem("linksAdmin");
    }
  },
  login({commit, dispatch}, credentials){
    return axios.post("/auth/login", credentials)
      .then(({data}) => {
        commit('SET_LOGIN_USER', data.metadata.access_token);
        dispatch('payloadToUser');
        return { redirect: true, errors: {}};
      })
      .catch(({errors}) => {
        return { redirect : false, errors };
      });
  },
  payloadToUser(){
    let token = localStorage.token;
    const base64Url = token.split(".")[1];
    const base64 = base64Url.replace("-", "+").replace("_", "/");
    let payload = JSON.parse(window.atob(base64));

    localStorage.setItem("user", JSON.stringify(payload.user));
  },
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
  },
  async getLinksAdmin({ commit }) {
    let token = localStorage.token;
    try {
      await axios.get(`/auth/links-admin?token=${token}`).then(resp => {
        commit("SET_LINKS_ADMIN", resp.data.metadata.links);
        
      });
    } catch (e) {
      console.log(e);
    }
  }
};

export default actions;
