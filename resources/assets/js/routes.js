import HomeCanal from "./pages/HomeCanal.vue";
import Listar from "./pages/Listar.vue";
import Exibir from "./pages/Exibir.vue";
import ConteudoForm from "./forms/ConteudoForm.vue";
import AplicativoForm from "./forms/AplicativoForm.vue";
import LoginForm from "./forms/LoginForm.vue";
import RecoverPassForm from "./forms/RecoverPassForm.vue";
import RegisterForm from "./forms/RegisterForm.vue";
import ListAdmin from "./components/ListAdmin.vue";
import DenunciaForm from "./forms/DenunciaForm.vue";
import FaleConoscoForm from "./forms/FaleConoscoForm.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import(/* webpackChunkName: "home" */ "./pages/Home.vue"),
    meta: {
      requiresAuth: false
    }
  },
  {
    path: "/admin",
    name: "Admin",
    component: () =>
      import(/* webpackChunkName: "admin" */ "./pages/Admin.vue"),
    meta: {
      requiresAuth: true
      //is_admin : true
    },
    children: [
      {
        path: ":slug/:action",
        name: "admin",
        components: {
          default: ListAdmin,
          admin: ListAdmin
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
          requiresAuth: false
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
      },

      {
        path: "adicionar",
        name: "AdicionarConteudo",
        component: ConteudoForm,
        meta: {
          requiresAuth: true,
          title: "Adicionar conteúdo"
        }
      },
      {
        path: "editar/:id",
        name: "EditarConteudo",
        component: ConteudoForm,
        meta: {
          requiresAuth: true,
          title: "Editar conteúdo"
        }
      },
      {
        path: "aplicativo/editar/:id",
        name: "EditarAplicativo",
        component: AplicativoForm,
        meta: {
          requiresAuth: true,
          title: "Editar aplicativo"
        }
      },
      {
        path: "aplicativo/adicionar",
        name: "AdicionarAplicativo",
        component: AplicativoForm,
        meta: {
          requiresAuth: true,
          title: "Adicionar aplicativo"
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
        name: "Login",
        component: LoginForm
      },
      {
        path: "recuperar-senha",
        name: "Recover",
        component: RecoverPassForm
      },
      {
        path: "registro",
        name: "Register",
        component: RegisterForm
      },
      {
        path: "denuncia",
        name: "DenunciaForm",
        component: DenunciaForm,
        meta: {
          requiresAuth: false,
          title: "Enviar denúncia"
        }
      },
      {
        path: "faleconosco",
        name: "FaleConoscoForm",
        component: FaleConoscoForm,
        meta: {
          requiresAuth: false,
          title: "Fale conosco"
        }
      }
    ]
  }
];

export default routes;
