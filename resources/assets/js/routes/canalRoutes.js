import HomeCanal from "../pages/HomeCanal.vue";
import Listar from "../pages/Listar.vue";
import Exibir from "../pages/Exibir.vue";

const canalRoutes = {
    path: "/:slug",
    component: () =>
      import(/* webpackChunkName: "canal" */ "../pages/Canal.vue"),
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
  };

export default canalRoutes;