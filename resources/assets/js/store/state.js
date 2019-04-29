const state = {
  conteudos: [],
  paginator: {},
  conteudo: {
    title: "",
    description: "",
    authors: "",
    source: "",
    license: "",
    image: "",
    tipo: "",
    terms: false,
    tags: [],
    canal: "",
    category: "",
    is_approved: false,
    is_featured: false,
    is_site: false,
    options: {
      tipo: {
        id: null,
        name: ""
      }
    }
  },
  aplicativos: [],
  aplicativo: {},
  canal: {},
  sidebar: {},
  categories: [],
  temas: [],
  disciplinas: [],
  components: [],
  licenses: [],
  tipos: [],
  license: "",
  tipo: "",
  showErrors: false,
  isTipoSite: false,
  niveis: [],
  menssage: "",
  title: "",
  show: false,
  isError: false,
  isLogged: !!localStorage.token,
  errors: {},
  alertText: "",
  showAlert: false,
  showConteudo: false,
  showApllicativo: false,
  formData: {},
  buttonText: "Salvar",
  notFound: false,
  isUpdate: false,
  isDelete: false,
  isCreate: true
};

export default state;
