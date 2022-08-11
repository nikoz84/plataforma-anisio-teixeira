// @ts-nocheck
import { 
  LoginForm, 
  RegisterForm, 
  RecoverPassForm, 
  MudarPassForm,
  ContactForm,
  ConfirmationEmailForm,
  MudarSenhaForm
} from "@/forms/auth-contato";
import Default from "@/layout/Default.vue";
import User from "@/pages/User.vue";



const usuarioRoutes = {
    path: "/usuario",
    name: "User",
    components: {
      main: User
    },
    meta: {
      requiresAuth: false,
      layout: Default
    },
    children: [
      {
        path: "login",
        name: "login",
        components: {
          user: LoginForm
        },
        meta: {
          requiresAuth: false,
          title: "faça seu login",
          layout: Default
        }
      },
      {
        path: "recuperar-senha",
        name: "Recuperar",
        components: {
          user: RecoverPassForm
        },
        meta: {
          requiresAuth: false,
          title: "Recuperar senha",
          layout: Default
        }
      },
      {
        path: "mudar-senha/:token",
        name: "MudarSenha",
        components: {
          user : MudarPassForm
        },
        meta: {
          //requiresAuth: true,
          title: "Mudar senha",
          layout: Default
        }
      },
      {
        path: "senha",
        name: "Senha",
        components: {
          user : MudarSenhaForm
        },
        meta: {
          requiresAuth: true,
          title: "Mudar senha",
          layout: Default
        }
      },
      {
        path: "registro",
        name: "Register",
        components: {
          user: RegisterForm
        },
        meta: {
          requiresAuth: false,
          title: "Faça seu registro",
          layout: Default
        }
      },
      {
        path: "confirmar-email",
        name: "confirmar",
        components: {user:ConfirmationEmailForm},
        meta: {
          requiresAuth: false,
          title: "Confirmar email",
          layout: Default
        }
      },
      {
        path: "contato/:action",
        name: "ContactForm",
        components:{
          user: ContactForm
        } ,
        meta: {
          requiresAuth: false,
          title: "Contatenos",
          layout: Default
        }
      }
    ]
};

export default usuarioRoutes;