const getters = {
  paginator: state => {
    return state.paginator;
  },
  getCanalById: state => {
    return state.conteudo;
  },
  getConteudos: state => {
    return state.conteudos;
  },
  getErrors: state => {
    return state.errors;
  },
  getCanal: state => {
    return state.canal;
  },
  getSidebar: state => {
    return state.sidebar;
  },
  getshowConteudo: state => {
    return state.showConteudo;
  },
  getshowAplicativo: state => {
    return state.showAplicativo;
  },
  getFormData: state => {
    return state.formData;
  },
  getConteudo: state => {
    return state.conteudo;
  }
};

export default getters;
