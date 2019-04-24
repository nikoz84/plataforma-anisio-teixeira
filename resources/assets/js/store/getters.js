const getters = {
  paginator: state => {
    return state.paginator;
  },
  getByIdCanal: state => id => {
    console.log(id);
    return state.paginator.data.find(item => item.id === id);
  },
  getCount: (state, getters) => {
    return getters.paginator ? getters.paginator.data.length : 0;
  },
  getError: state => {
    return state.error;
  },
  getCanal: state => {
    return state.canal;
  },
  getSidebar: state => {
    return state.sidebar;
  }
};

export default getters;
