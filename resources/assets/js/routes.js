import HomeCanal from "./pages/HomeCanal.vue";
import Listar from "./pages/Listar.vue";
import Exibir from "./pages/Exibir.vue";
import ConteudoForm from "./forms/ConteudoForm.vue";
import AplicativoForm from "./forms/AplicativoForm.vue";
import LoginForm from "./forms/LoginForm.vue";
import RecoverPassForm from "./forms/RecoverPassForm.vue";
import RegisterForm from "./forms/RegisterForm.vue";
import UserEditForm from "./forms/UserEditForm.vue";
import CanalForm from "./forms/CanalForm.vue";
import ListAdmin from "./components/ListAdminComponent.vue";
import DenunciaForm from "./forms/DenunciaForm.vue";
import FaleConoscoForm from "./forms/FaleConoscoForm.vue";
import UsuarioForm from "./forms/UsuarioForm.vue";
import ListarUser from "./pages/ListarUser.vue";
import OptionsForm from "./forms/OptionsForm.vue";

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
        path: "listar/:canal",
        name: "ListarItens",
        component: ListAdmin
      },
      {
        path: "adicionar-canal",
        name: "AddCanal",
        component: CanalForm
      },
      {
        path: "metadados",
        name: "Opcoes",
        component: OptionsForm
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
        path: "editar/:id",
        name: "UserEdit",
        component: UserEditForm
      },
      {
        path: "adicionar",
        name: "Create",
        component: UsuarioForm
      },
      {
        path: "listar",
        name: "UserList",
        component: ListarUser
      },
      {
        path: "editar/:id",
        name: "EditarUsuario",
        component: UsuarioForm
      }
    ]
  },
  {
    path: "/:slug",
    component: () =>
      import(/* webpackChunkName: "canal" */ "./pages/Canal.vue"),
    meta: {
      requiresAuth: false
    },
    children: [
      {
        path: "/",
        name: "Inicio",
        component: HomeCanal
      },
      {
        path: "listar",
        name: "Listar",
        component: Listar
      },
      {
        path: "listar/tag/:id",
        name: "listarTagId",
        component: Listar
      },
      {
        path: "exibir/:id",
        name: "Exibir",
        component: Exibir
      },
      {
        path: "editar-conteudo/:id",
        name: "EditarConteudo",
        component: ConteudoForm,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: "adicionar-conteudo",
        name: "AdicionarConteudo",
        component: ConteudoForm,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: "editar-aplicativo/:id",
        name: "EditarAplicativo",
        component: AplicativoForm,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: "adicionar-aplicativo",
        name: "AdicionarAplicativo",
        component: AplicativoForm,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: "denuncia/:url",
        name: "DenunciaForm",
        component: DenunciaForm
      },
      {
        path: "faleconosco/:url",
        name: "FaleConoscoForm",
        component: FaleConoscoForm
      }
    ]
  }
];

export default routes;
