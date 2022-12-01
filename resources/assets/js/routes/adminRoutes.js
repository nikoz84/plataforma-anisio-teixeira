import Admin from "@layout/Admin";
import {
  ListarConteudos,
  ListarAplicativos,
  ListarCanais,
  ListarContato,
  ListarOptions,
  ListarRoles,
  ListarTags,
  ListarTipos,
  ListarUsers,
  ListarCategorias,
  ListarComponentes,
  ListarComponentesCategoria,
  ListarNiveisEnsino,
} from "@components/exibir";
import {
  ConteudoForm,
  PlayListForm,
  AplicativoForm,
  CanalForm,
  OptionsForm,
  RoleForm,
  TagForm,
  TipoForm,
  UserForm,
  CategoryConteudoForm,
  CurricularComponentsForm,
  CurricularComponentsCategoryForm,
  NivelEnsinoForm,
} from "@forms/models";
import AdminPage from "@pages/AdminPage.vue";
import { Contato } from "@components/exibir";
import {
  listarDashboardRoute,
  conteudoPorAnoRoute,
  catalogacaoPorCanalRoute,
  catalogacaoMensalPorUsuarioRoute,
  catalogacaoTotalMensalRoute,
  conteudosMaisBaixadosRoute,
  conteudosMaisAcessadosRoute,
  tagsMaisProcuradasRoute,
  aplicativosMaisVisualizadosRoute,
  tiposDeMidiaRoute,
} from "./dashboardRoutes";

const adminRoutes = {
  path: "/admin",
  name: "admin-home",
  components: {
    main: AdminPage,
  },
  meta: {
    requiresAuth: true,
    layout: Admin,
  },
  children: [
    listarDashboardRoute,
    conteudoPorAnoRoute,
    catalogacaoPorCanalRoute,
    catalogacaoMensalPorUsuarioRoute,
    catalogacaoTotalMensalRoute,
    conteudosMaisBaixadosRoute,
    conteudosMaisAcessadosRoute,
    tagsMaisProcuradasRoute,
    aplicativosMaisVisualizadosRoute,
    tiposDeMidiaRoute,
    {
      path: "conteudos/listar",
      components: { admin: ListarConteudos },
      meta: {
        requiresAuth: true,
        title: "Listar Conteúdos",
        layout: Admin,
      },
    },
    {
      path: "conteudos/adicionar",
      components: { admin: ConteudoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin,
      },
    },
    {
      path: "conteudos/editar/:id",
      components: { admin: ConteudoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin,
      },
    },
    {
      path: "aplicativos/editar/:id",
      components: { admin: AplicativoForm },
      meta: {
        requiresAuth: true,
        title: "Editar Aplicativo",
        layout: Admin,
      },
    },
    {
      path: "aplicativos/adicionar",
      components: { admin: AplicativoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Aplicativo",
        layout: Admin,
      },
    },
    {
      path: "aplicativos/listar",
      components: { admin: ListarAplicativos },
      meta: {
        requiresAuth: true,
        title: "Adicionar Aplicativo",
        layout: Admin,
      },
    },
    {
      path: "playlist/listar",
      components: { admin: PlayListForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Conteúdo",
        layout: Admin,
      },
    },
    {
      path: "canais/listar",
      components: { admin: ListarCanais },
      meta: {
        requiresAuth: true,
        title: "Listar Canais",
        layout: Admin,
      },
    },
    {
      path: "canais/adicionar",
      components: { admin: CanalForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Canal",
        layout: Admin,
      },
    },
    {
      path: "canais/editar/:id",
      components: { admin: CanalForm },
      meta: {
        requiresAuth: true,
        title: "Editar Canal",
        layout: Admin,
      },
    },
    {
      path: "contato/listar",
      components: { admin: ListarContato },
      meta: {
        requiresAuth: true,
        title: "Listar faleconosco",
        layout: Admin,
      },
    },
    {
      path: "contato/responder/:id",
      components: { admin: Contato },
      meta: {
        requiresAuth: true,
        title: "Responder faleconosco",
        layout: Admin,
      },
    },
    ,
    {
      path: "options/listar",
      components: { admin: ListarOptions },
      meta: {
        requiresAuth: true,
        title: "Listar opções do sistema",
        layout: Admin,
      },
    },
    {
      path: "options/editar/:id",
      components: { admin: OptionsForm },
      meta: {
        requiresAuth: true,
        title: "Opçao para editar",
        layout: Admin,
      },
    },
    {
      path: "roles/listar",
      components: { admin: ListarRoles },
      meta: {
        requiresAuth: true,
        title: "Listar tipos de usuários",
        layout: Admin,
      },
    },
    {
      path: "roles/editar/:id",
      components: { admin: RoleForm },
      meta: {
        requiresAuth: true,
        title: "Editar Role",
        layout: Admin,
      },
    },
    {
      path: "roles/adicionar",
      components: { admin: RoleForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Role",
        layout: Admin,
      },
    },
    {
      path: "tags/listar",
      components: { admin: ListarTags },
      meta: {
        requiresAuth: true,
        title: "Listar palavras-chave",
        layout: Admin,
      },
    },
    {
      path: "tags/editar/:id",
      components: { admin: TagForm },
      meta: {
        requiresAuth: true,
        title: "Editar palavras-chave",
        layout: Admin,
      },
    },
    {
      path: "tags/adicionar",
      components: { admin: TagForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar palavra-chave",
        layout: Admin,
      },
    },
    {
      path: "tipos/listar",
      components: { admin: ListarTipos },
      meta: {
        requiresAuth: true,
        title: "Listar tipos de conteúdos",
        layout: Admin,
      },
    },
    {
      path: "tipos/editar/:id",
      components: { admin: TipoForm },
      meta: {
        requiresAuth: true,
        title: "Editar tipo de conteúdo",
        layout: Admin,
      },
    },
    {
      path: "tipos/adicionar",
      components: { admin: TipoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar tipo de conteúdo",
        layout: Admin,
      },
    },
    {
      path: "usuarios/listar",
      components: { admin: ListarUsers },
      meta: {
        requiresAuth: true,
        title: "Listar usuários",
        layout: Admin,
      },
    },
    {
      path: "usuarios/editar/:id",
      components: { admin: UserForm },
      meta: {
        requiresAuth: true,
        title: "Editar usuário",
        layout: Admin,
      },
    },
    {
      path: "usuarios/adicionar",
      components: { admin: UserForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar usuário",
        layout: Admin,
      },
    },
    {
      path: "categorias/listar",
      components: { admin: ListarCategorias },
      meta: {
        requiresAuth: true,
        title: "Listar categorias",
        layout: Admin,
      },
    },
    {
      path: "categorias/editar/:id",
      components: { admin: CategoryConteudoForm },
      meta: {
        requiresAuth: true,
        title: "Editar categoria",
        layout: Admin,
      },
    },
    {
      path: "categorias/adicionar",
      components: { admin: CategoryConteudoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar categoria",
        layout: Admin,
      },
    },
    {
      path: "componentes/listar",
      components: { admin: ListarComponentes },
      meta: {
        requiresAuth: true,
        title: "Listar componentes",
        layout: Admin,
      },
    },
    {
      path: "componentes/editar/:id",
      components: { admin: CurricularComponentsForm },
      meta: {
        requiresAuth: true,
        title: "Editar Componente Curricular",
        layout: Admin,
      },
    },
    {
      path: "componentes/adicionar",
      components: { admin: CurricularComponentsForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Componente Curricular",
        layout: Admin,
      },
    },
    {
      path: "componentes-categoria/listar",
      components: { admin: ListarComponentesCategoria },
      meta: {
        requiresAuth: true,
        title: "Listar categoria componentes curriculares",
        layout: Admin,
      },
    },
    {
      path: "componentes-categoria/editar/:id",
      components: { admin: CurricularComponentsCategoryForm },
      meta: {
        requiresAuth: true,
        title: "Editar Categoria Componente Curricular",
        layout: Admin,
      },
    },
    {
      path: "componentes-categoria/adicionar",
      components: { admin: CurricularComponentsCategoryForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar Categoria Componente Curricular",
        layout: Admin,
      },
    },
    {
      path: "niveis-ensino/listar",
      components: { admin: ListarNiveisEnsino },
      meta: {
        requiresAuth: true,
        title: "Listar niveis de ensino",
        layout: Admin,
      },
    },
    {
      path: "niveis-ensino/editar/:id",
      components: { admin: NivelEnsinoForm },
      meta: {
        requiresAuth: true,
        title: "Editar nivel de ensino",
        layout: Admin,
      },
    },
    {
      path: "niveis-ensino/adicionar",
      components: { admin: NivelEnsinoForm },
      meta: {
        requiresAuth: true,
        title: "Adicionar nivel de ensino",
        layout: Admin,
      },
    },
  ],
};

export default adminRoutes;
