const state = {
  layout: {},
  homeData: {},
  links: [],
  conteudos: [],
  paginator: {},
  conteudo: {},
  aplicativos: [],
  aplicativo: {},
  posts: [],
  canais: [],
  canal: {},
  sidebar: {},
  categories: [],
  niveis: {},
  temas: [],
  disciplinas: {},
  components: [],
  licenses: [],
  childsLicenses: [],
  tipos: [],
  tiposForm: [],
  showErrors: false,
  isTipoSite: false,
  message: "",
  isError: false,
  isLogged: !!localStorage.token,
  isLoading: false,
  componentId: "",
  exibirId: "",
  errors: {},
  alertText: "",
  showAlert: false,
  formData: {},
  buttonText: "Salvar",
  viewport: {
    width: 0,
    heigth: 0
  }

};

export default state;
