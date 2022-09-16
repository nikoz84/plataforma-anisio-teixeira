import Dashboard from "@pages/Dashboard.vue";
import { ConteudosPorAno, CatalogacaoMensal } from "@components/dashboard";
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
    }

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
}
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
}


export {
    listarDashboardRoute,
    conteudoPorAnoRoute,
    catalogacaoMensalRoute
}