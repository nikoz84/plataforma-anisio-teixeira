// @ts-nocheck
//import { LoaderAdmin } from "@components/exibir";
import Admin from "@layout/Admin";
import { ListarConteudos, ListarAplicativos, ListarCanais } from "@components/exibir"
import { ConteudoForm, PlayListForm, AplicativoForm } from "@forms/models";
import AdminPage from "@pages/AdminPage.vue"

const adminRoutes = {
  path: "/admin",
  //name: "admin-home",
  components : {
    main: AdminPage
  },
  meta: {
    requiresAuth: true,
    layout : Admin
  },
  children: [
    {
      path: "conteudos/listar",
      components: {  
        admin: ListarConteudos
      },
      meta: {
        requiresAuth: true,
        title: "Listar Conteúdos",
        layout: Admin
      }
    },
    {
      path: "conteudos/adicionar",
      components: {admin: ConteudoForm},
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin
      }
    },
    {
      path: "conteudos/editar/:id",
      components: { admin: ConteudoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin
      }
    },
    {
      path: "aplicativos/editar/:id",
      components: { admin: AplicativoForm },
      meta: {
        requiresAuth: true,
        title: "Editar Aplicativo",
        layout: Admin
      }
    },
    {
      path: "aplicativos/adicionar",
      components: { admin: AplicativoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Aplicativo",
        layout: Admin
      }
    },
    {
      path: "aplicativos/listar",
      components: { admin: ListarAplicativos },
      meta: {
        requiresAuth: true,
        title: "Adicionar Aplicativo",
        layout: Admin
      }
    },
    {
      path: "playlist/listar",
      components: { admin: PlayListForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin
      }
    }

  ]
  /*
  children: [
    {
      path: ":slug/:action/:id?",
      name: "admin",
      components: {
        default: LoaderAdmin,
        admin: LoaderAdmin
      },
      meta: {
        requiresAuth: true,
        title: "Administração"
      }
    }
  ]*/
};

export default adminRoutes;