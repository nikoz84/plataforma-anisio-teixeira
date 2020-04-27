
const getters = {
  getLayout: state => {
    return state.layout;
  },
  getPaginator: state => {
    return state.paginator;
  },
  getCanalById: state => {
    return state.canal;
  },
  getConteudos: state => {
    return state.conteudos;
  },
  getConteudo: state => {
    return state.conteudo;
  },
  getErrors: state => {
    return state.errors;
  },
  getCanal: state => {
    return state.canal;
  },
  getCanais: state => {
    return state.canais;
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
  getTipos: state => {
    return state.tipos;
  },
  getIsError: state => {
    return state.isError;
  },
  getTextAlert: state => {
    return state.textAlert;
  },
  getShowAlert: state => {
    return state.showAlert;
  },
  getshowLicenses: state => {
    return state.licenses;
  },
  getFormData: state => {
    return state.formData;
  },
  getRecaptcha: state => {
    return state.recaptcha;
  },
  //getConteudo: state => {
  //return state.conteudo;
  //},
  getButtonText: state => {
    return state.buttonText;
  },
  getAction: state => {
    return state.action;
  },
  getWindow: state => {
    return state.viewport;
  }
};

export default getters;
