const getters = {
  paginator: state => {
    return state.paginator;
  },
  getCanalById: state => {
    return state.conteudo;
  },
  getConteudos: state => {
    return state.conteudo;
  },
  getError: state => {
    return state.error;
  },
  getCanal: state => {
    return state.canal;
  },
  getSidebar: state => {
    return state.sidebar;
  },
  getCanalId: state => {
    return state.canalId;
  }
};

export default getters;
