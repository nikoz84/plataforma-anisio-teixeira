import Dashboard from "@pages/Dashboard.vue";
import {
  ConteudosPorAno,
  CatalogacaoMensal,
  CatalogacaoPorCanal,
  CatalogacaoMensalPorUsuario,
  CatalogacaoTotalMensal,
  ConteudosMaisBaixados,
  ConteudosMaisAcessados,
  TagsMaisProcuradas,
  AplicativosMaisVisualizados,
  TiposDeMidia,
} from "@components/dashboard";
import Admin from "@layout/Admin";

const listarDashboardRoute = {
  path: "dashboard/listar",
  components: {
    admin: Dashboard,
  },
  meta: {
    requiresAuth: true,
    title: "Estatisticas",
    layout: Admin,
  },
};

const conteudoPorAnoRoute = {
  path: "dashboard/conteudos-por-ano",
  components: {
    admin: ConteudosPorAno,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação por ano",
    layout: Admin,
  },
};
const catalogacaoMensalRoute = {
  path: "dashboard/catalogacao-mensal",
  components: {
    admin: CatalogacaoMensal,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação mensal",
    layout: Admin,
  },
};

const catalogacaoPorCanalRoute = {
  path: "dashboard/catalogacao-por-canal",
  components: {
    admin: CatalogacaoPorCanal,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação Por Canal",
    layout: Admin,
  },
};

const catalogacaoMensalPorUsuarioRoute = {
  path: "dashboard/catalogacao-mensal-por-usuario",
  components: {
    admin: CatalogacaoMensalPorUsuario,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação mensal por usuário",
    layout: Admin,
  },
};

const catalogacaoTotalMensalRoute = {
  path: "dashboard/catalogacao-total-mensal",
  components: {
    admin: CatalogacaoTotalMensal,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação total mensal ",
    layout: Admin,
  },
};

const conteudosMaisBaixadosRoute = {
  path: "dashboard/conteudos-mais-baixados",
  components: {
    admin: ConteudosMaisBaixados,
  },
  meta: {
    requiresAuth: true,
    title: "Conteudos mais baixados ",
    layout: Admin,
  },
};

const conteudosMaisAcessadosRoute = {
  path: "dashboard/conteudos-mais-acessados",
  components: {
    admin: ConteudosMaisAcessados,
  },
  meta: {
    requiresAuth: true,
    title: "Conteudos mais acessados ",
    layout: Admin,
  },
};

const tagsMaisProcuradasRoute = {
  path: "dashboard/tags-mais-procuradas",
  components: {
    admin: TagsMaisProcuradas,
  },
  meta: {
    requiresAuth: true,
    title: "Tags mais procuradas ",
    layout: Admin,
  },
};

const aplicativosMaisVisualizadosRoute = {
  path: "dashboard/aplicativos-mais-visualizados",
  components: {
    admin: AplicativosMaisVisualizados,
  },
  meta: {
    requiresAuth: true,
    title: "Aplicativos mais visualizados ",
    layout: Admin,
  },
};

const tiposDeMidiaRoute = {
  path: "dashboard/tipos-de-midia",
  components: {
    admin: TiposDeMidia,
  },
  meta: {
    requiresAuth: true,
    title: "Tipos de mídia ",
    layout: Admin,
  },
};

export {
  listarDashboardRoute,
  conteudoPorAnoRoute,
  catalogacaoMensalRoute,
  catalogacaoPorCanalRoute,
  catalogacaoMensalPorUsuarioRoute,
  catalogacaoTotalMensalRoute,
  conteudosMaisBaixadosRoute,
  conteudosMaisAcessadosRoute,
  tagsMaisProcuradasRoute,
  aplicativosMaisVisualizadosRoute,
  tiposDeMidiaRoute,
};
