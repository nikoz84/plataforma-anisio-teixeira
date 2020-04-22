import Sobre from "../pages/Sobre.vue";
import Index from "../pages/Index.vue";
import Galeria from "../pages/Galeria.vue";
import LoginForm from "../forms/LoginForm.vue";
import RecoverPassForm from '../forms/RecoverPassForm.vue';

const home = {
    path: "/",
    component: () => import(/* webpackChunkName: "home" */ "../pages/Home.vue"),
    meta: {
        requiresAuth: false,
        title: "Inicio"
    },
    children: [
        {
            path: "",
            name:"HomeIndex",
            components: {
                default: Index,
                home: Index
              },
              meta: {
                requiresAuth: false,
                title: "Inicio"
              }
        },
        {
          path: "sobre",
          name: "HomeSobre",
          components: {
            default: Sobre,
            home: Sobre
          },
          meta: {
            requiresAuth: false,
            title: "Sobre a plataforma"
          }
        },
        {
            path: "galeria",
            name: "HomeGaleria",
            components: {
              default: Galeria,
              home: Galeria
            },
            meta: {
              requiresAuth: false,
              title: "Galeria de fotos"
            }
        },
        {
            path: "login",
            name: "HomeLogin",
            components: {
              default: LoginForm,
              home: LoginForm
            },
            meta: {
              requiresAuth: false,
              title: "Iniciar Sessão"
            }
        },
        {
            path: "recuperar-senha",
            name: "HomeRecoverPass",
            components: {
              default: RecoverPassForm,
              home: RecoverPassForm
            },
            meta: {
              requiresAuth: false,
              title: "Recuperar Senha"
            }
        }
    ]

};

export default home;
