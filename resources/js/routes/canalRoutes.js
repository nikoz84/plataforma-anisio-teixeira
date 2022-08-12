

//import PageNotFound from "@/pages/PageNotFound.vue";

const canalRoutes = {
    path: "/:slug",
    components: {
      main: () => import("@/pages/Canal.vue")
    },
    meta: {
      requiresAuth: false,
      title: "Canal",
      layout: () => import("@/layout/Default.vue")
    },
    children: [
      {
        path: "/",
        name: "Inicio",
        components:{
          canal: () => import("@/pages/HomeCanal.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Inicio",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "listar",
        name: "Listar",
        components:{
          canal: () => import("@/pages/Listar.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Listar Conteúdos",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "listar/tag/:id",
        name: "listarTagId",
        components:{
          canal: () => import("@/pages/Listar.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Lista de conteúdos por tag",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "conteudo/exibir/:id",
        name: "ExibirConteudo",
        components: {
          canal: () => import("@/pages/Exibir.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Exibir conteúdo digital",
          layout: () => import("@/layout/Default.vue")
        }
      },
      {
        path: "aplicativo/exibir/:id",
        name: "ExibirAplicativo",
        components: {
          canal : () => import("@/pages/Exibir.vue")
        },
        meta: {
          requiresAuth: false,
          title: "Exibir aplicativo educacional",
          layout: () => import("@/layout/Default.vue")
        }
      }
    ]
  };

export default canalRoutes;