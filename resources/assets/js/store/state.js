import conteudo from "./models/conteudo";

const state = {
  conteudos: [],
  paginator: {},
  conteudo:{
    license_id: "",
    canal_id: "",
    category_id: "",
    options: {
      tipo: {
        id: "",
        name: ""
      },
      site:""
    },
    title: "",
    description: "",
    authors: "",
    source: "",
    image: "",
    tags: [],
    niveis: [],
    components: [],
    terms: false,
    is_approved: false,
    is_featured: false,
    is_site: false
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
  showErrors: false,
  isTipoSite: false,
  niveis: [],
  message: "",
  //title: "",
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
  action: ""
};

export default state;
