// @ts-nocheck
import { 
  LoginForm, 
  RegisterForm, 
  RecoverPassForm, 
  MudarPassForm,
  ContactForm,
  ConfirmationEmailForm
} from "@forms/auth-contato";





const usuarioRoutes = {
    path: "/usuario",
    name: "User",
    component: () => import(/* webpackChunkName: "user" */ "@pages/User.vue"),
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
        path: "mudar-senha/:token",
        name: "MudarSenha",
        component: MudarPassForm,
        meta: {
          //requiresAuth: true,
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
};

export default usuarioRoutes;