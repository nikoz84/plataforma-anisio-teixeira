
const usuarioRoutes = {
    path: "/usuario",
    name: "User",
    components: {
      main: () => import("@/pages/User.vue")
    },
    meta: {
      requiresAuth: false,
      layout: () => import("@/layout/Default.vue")
    },
    children: [
      {
        path: "login",
        name: "login",
        components: {
          user: () => import("@/forms/auth-contato/LoginForm.vue")
        },
        meta: {
          requiresAuth: false,
          title: "faça seu login",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "recuperar-senha",
        name: "Recuperar",
        components: {
          user: () => import("@/forms/auth-contato/RecoverPassForm.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Recuperar senha",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "mudar-senha/:token",
        name: "MudarSenha",
        components: {
          user : () => ("@/forms/auth-contato/MudarPassForm.vue")
        },
        meta: {
          //requiresAuth: true,
          title: "Mudar senha",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "senha",
        name: "Senha",
        components: {
          user : () => import("@/forms/auth-contato/MudarSenhaForm.vue")
        },
        meta: {
          requiresAuth: true,
          title: "Mudar senha",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "registro",
        name: "Register",
        components: {
          user: () => import("@/forms/auth-contato/RegisterForm.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Faça seu registro",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "confirmar-email",
        name: "confirmar",
        components: {user:() => import("@/forms/auth-contato/ConfirmationEmailForm.vue")},
        meta: {
          requiresAuth: false,
          title: "Confirmar email",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "contato/:action",
        name: "ContactForm",
        components:{
          user: () => import("@/forms/auth-contato/ContactForm.vue")
        } ,
        meta: {
          requiresAuth: false,
          title: "Contatenos",
          layout: () => import("@/layout/Default.vue")
        }
      }
    ]
};

export default usuarioRoutes;