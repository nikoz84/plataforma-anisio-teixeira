const state = {
  isLogged: !!localStorage.token,
  usuario: {},
  usuarios: [],
  showAlert: false,
  paginator: {},
  response: {},
  message: "",
  isError: false,
  errors: {},
  conteudos: [],
  conteudo: {},
  aplicativos: [],
  aplicativo: []
};

export default state;
