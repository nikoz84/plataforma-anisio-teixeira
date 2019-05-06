import { getField } from "vuex-map-fields";

const getters = {
  getField,
  paginator: state => {
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
  getshowLicenses: state => {
    return state.licenses;
  },
  getFormData: state => {
    return state.formData;
  },
  //getConteudo: state => {
  //return state.conteudo;
  //},
  getButtonText: state => {
    return state.buttonText;
  },
  getAction: state => {
    return state.action;
  }
};

export default getters;
