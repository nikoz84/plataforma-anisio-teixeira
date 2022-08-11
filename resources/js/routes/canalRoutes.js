// @ts-nocheck
import HomeCanal from "@/pages/HomeCanal.vue";
import Listar from "@/pages/Listar.vue";
import Exibir from "@/pages/Exibir.vue";
import Canal from "@/pages/Canal.vue";
import Default from "@/layout/Default.vue";
import PageNotFound from "@/pages/PageNotFound.vue";

const canalRoutes = {
    path: "/:slug",
    components: {
      main: Canal
    },
    meta: {
      requiresAuth: false,
      title: "Canal",
      layout: Default
    },
    children: [
      {
        path: "/",
        name: "Inicio",
        components:{
          canal: HomeCanal
        },
        meta: {
          requiresAuth: false,
          title: "Inicio",
          layout: Default
        }
      },
      {
        path: "listar",
        name: "Listar",
        components:{
          canal: Listar
        },
        meta: {
          requiresAuth: false,
          title: "Listar Conteúdos",
          layout: Default
        }
      },
      {
        path: "listar/tag/:id",
        name: "listarTagId",
        components:{
          canal: Listar
        },
        meta: {
          requiresAuth: false,
          title: "Lista de conteúdos por tag",
          layout: Default
        }
      },
      {
        path: "conteudo/exibir/:id",
        name: "ExibirConteudo",
        components: {
          canal: Exibir
        },
        meta: {
          requiresAuth: false,
          title: "Exibir conteúdo digital",
          layout: Default
        }
      },
      {
        path: "aplicativo/exibir/:id",
        name: "ExibirAplicativo",
        components: {
          canal : Exibir
        },
        meta: {
          requiresAuth: false,
          title: "Exibir aplicativo educacional",
          layout: Default
        }
      }
    ]
  };

export default canalRoutes;