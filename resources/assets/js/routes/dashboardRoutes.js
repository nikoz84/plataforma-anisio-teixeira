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
  AplicativosMaisVizualizados,
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
  path: "/catalogacao-mensal",
  components: {
    admin: CatalogacaoMensal,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação mensal",
    layout: Admin,
  },
};
const tagsMaisProcuradasRoute = {
  path: "/tags-mais-procuradas",
  components: {
    admin: TagsMaisProcuradas,
  },
  meta: {
    requiresAuth: true,
    title: "Tags mais procuradas",
    layout: Admin,
  },
};
const aplicativosMaisVizualizadosRoute = {
  path: "/aplicativos-mais-vizualizados",
  components: {
    admin: AplicativosMaisVizualizados,
  },
  meta: {
    requiresAuth: true,
    title: "Aplicativos mais vizualizados",
    layout: Admin,
  },
};
const catalogacaoMensalPorUsuarioRoute = {
  path: "/catalogacao-mensal-por-usuario",
  components: {
    admin: CatalogacaoMensalPorUsuario,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação mensal por usuario",
    layout: Admin,
  },
};
const tiposDeMidiaRoute = {
  path: "/tipos-de-midia",
  components: {
    admin: TiposDeMidia,
  },
  meta: {
    requiresAuth: true,
    title: "Tipos de Mídia",
    layout: Admin,
  },
};
const conteudosMaisBaixadosRoute = {
  path: "/conteudo-mais-baixados",
  components: {
    admin: ConteudosMaisBaixados,
  },
  meta: {
    requiresAuth: true,
    title: "Conteúdos mais baixados",
    layout: Admin,
  },
};
const conteudosMaisAcessadosRoute = {
  path: "/conteudos-mais-acessados",
  components: {
    admin: ConteudosMaisAcessados,
  },
  meta: {
    requiresAuth: true,
    title: "Conteúdos mais acessados",
    layout: Admin,
  },
};
const catalogacaoTotalMensalRoute = {
  path: "/catalogacao-total-mensal",
  components: {
    admin: CatalogacaoTotalMensal,
  },
  meta: {
    requiresAuth: true,
    title: "Tipos de Mídia",
    layout: Admin,
  },
};
const catalogacaoPorCanalRoute = {
  path: "/catalogacao-por-canal",
  components: {
    admin: CatalogacaoPorCanal,
  },
  meta: {
    requiresAuth: true,
    title: "Catalogação por Canal",
    layout: Admin,
  },
};
export {
  listarDashboardRoute,
  conteudoPorAnoRoute,
  catalogacaoMensalRoute,
  tagsMaisProcuradasRoute,
  aplicativosMaisVizualizadosRoute,
  catalogacaoMensalPorUsuarioRoute,
  tiposDeMidiaRoute,
  conteudosMaisBaixadosRoute,
  conteudosMaisAcessadosRoute,
  catalogacaoTotalMensalRoute,
  catalogacaoPorCanalRoute,
};
