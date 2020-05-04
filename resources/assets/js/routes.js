import HomeCanal from "./pages/HomeCanal.vue";
import Listar from "./pages/Listar.vue";
import Exibir from "./pages/Exibir.vue";
import LoginForm from "./forms/LoginForm.vue";
import MudarPassForm from "./forms/MudarPassForm.vue";
import RecoverPassForm from "./forms/RecoverPassForm.vue";
import RegisterForm from "./forms/RegisterForm.vue";
import ListAdmin from "./components/ListAdmin.vue";
import ContactForm from "./forms/ContactForm.vue";
import Gallery from "./components/Gallery.vue";
import ConfirmationEmailForm from "./forms/ConfirmationEmailForm.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import(/* webpackChunkName: "home" */ "./pages/Home.vue"),
    meta: {
      requiresAuth: false,
      title: "Inicio"
    }
  },
  {
    path: "/galeria",
    name: "Galeria",
    component: Gallery,
    meta: {
      requiresAuth: false,
      title: "Galeria de Imagens"
    }
  },
  {
    path: "/sobre",
    name: "Sobre",
    component: () =>
      import(/* webpackChunkName: "sobre" */ "./pages/Sobre.vue"),
    meta: {
      requiresAuth: false,
      title: "Sobre a Plataforma"
    }
  },
  {
    path: "/praticas-pedagogicas",
    name: "PraticasPedagogicas",
    component: () =>
      import(
        /* webpackChunkName: "praticas" */ "./pages/PraticasPedagogicas.vue"
      ),
    meta: {
      requiresAuth: false,
      title: "Pŕaticas pedagógicas"
    }
  },
  {
    path: "/admin",
    name: "admin-home",
    component: () =>
      import(/* webpackChunkName: "admin" */ "./pages/Admin.vue"),
    meta: {
      requiresAuth: true
      //is_admin : true
    },
    children: [
      {
        path: ":slug/:action/:id?",
        name: "admin",
        components: {
          default: ListAdmin,
          admin: ListAdmin
        },
        meta: {
          requiresAuth: true,
          title: "Administração"
        }
      }
    ]
  },
  {
    path: "/:slug",
    component: () =>
      import(/* webpackChunkName: "canal" */ "./pages/Canal.vue"),
    meta: {
      requiresAuth: false,
      title: "Canal"
    },
    children: [
      {
        path: "/",
        name: "Inicio",
        component: HomeCanal,
        meta: {
          requiresAuth: false,
          title: "Inicio"
        }
      },
      {
        path: "listar",
        name: "Listar",
        component: Listar,
        meta: {
          requiresAuth: false,
          title: "Listar Conteúdos"
        }
      },
      {
        path: "listar/tag/:id",
        name: "listarTagId",
        component: Listar,
        meta: {
          requiresAuth: false,
          title: "Lista de conteúdos por tag"
        }
      },
      {
        path: "conteudo/exibir/:id",
        name: "ExibirConteudo",
        component: Exibir,
        meta: {
          requiresAuth: false,
          title: "Exibir conteúdo digital"
        }
      },
      {
        path: "aplicativo/exibir/:id",
        name: "ExibirAplicativo",
        component: Exibir,
        meta: {
          requiresAuth: false,
          title: "Exibir aplicativo educacional"
        }
      }
    ]
  },
  {
    path: "/usuario",
    name: "User",
    component: () => import(/* webpackChunkName: "user" */ "./pages/User.vue"),
    meta: {
      requiresAuth: false
    },
    children: [
      {
        path: "login",
        name: "login",
        component: LoginForm,
        meta: {
          requiresAuth: false,
          title: "faça seu login"
        }
      },
      {
        path: "recuperar-senha",
        name: "Recuperar",
        component: RecoverPassForm,
        meta: {
          requiresAuth: false,
          title: "Recuperar senha"
        }
      },
      {
        path: "mudar-senha",
        name: "MudarSenha",
        component: MudarPassForm,
        meta: {
          requiresAuth: true,
          title: "Mudar senha"
        }
      },
      {
        path: "registro",
        name: "Register",
        component: RegisterForm,
        meta: {
          requiresAuth: false,
          title: "Faça seu registro"
        }
      },
      {
        path: "confirmar-email",
        name: "confirmar",
        component: ConfirmationEmailForm,
        meta: {
          requiresAuth: false,
          title: "Confirmar email"
        }
      },
      {
        path: "contato/:action",
        name: "ContactForm",
        component: ContactForm,
        meta: {
          requiresAuth: false,
          title: "Contatenos"
        }
      }
    ]
  }
];

export default routes;
