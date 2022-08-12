
import Default from "@/layout/Default.vue";
import Home from "@/pages/Home.vue";
import Ipes from "@/pages/Ipes.vue";

const homeRoute = {
    path: "/",
    name: "Home",
    components: { default: Home, main:Home },
    meta: {
      requiresAuth: false,
      title: "Inicio",
      layout: Default
    }
};
  
const galeriaRoute = {
    path: "/galeria",
    name: "Galeria",
    components: {
      main: () => import("@/components/home/Gallery.vue")
    },
    meta: {
      requiresAuth: false,
      title: "Galeria de Imagens",
      layout: Default
    }
};
const sobreRoute = {
    path: "/sobre",
    name: "Sobre",
    components:{
      main : () => import("@/pages/Sobre.vue")
    },
    meta: {
      requiresAuth: false,
      title: "Sobre a Plataforma",
      layout: Default 
    }
};

const praticasRoute = {
    path: "/praticas-pedagogicas",
    name: "PraticasPedagogicas",
    components: 
    { main: () => import("@/pages/PraticasPedagogicas.vue")},
    meta: {
      requiresAuth: false,
      title: "Pŕaticas pedagógicas",
      layout: Default
    }
};

const ipesRoute = {
  path: "/ipes",
  name: "IpesFaculdades",
  components: { main : Ipes},
  meta: {
      requiresAuth: false,
      title: "Faculdades da Bahia",
      layout: Default
    }
};
const rotinasRoute = {
  path: "/rotinas-de-estudo/:nivel?/:semana?",
  name: "RotinasEstudo",
  components: { main : () => import("@/pages/RotinasDeEstudo.vue")},
  meta: {
      requiresAuth: false,
      title: "Rotinas de Estudo",
      layout: Default
    }
};

const advancedSearch = {
  path: "/busca-avancada",
  name: "BuscaAvancada",
  components: { main: () => import("@/pages/AdvancedSearch.vue")},
  meta: {
      requiresAuth: false,
      title: "Busca Avançada",
      layout: Default
    }
};


const praticasInspiradoras = {
  path: "/praticas-inspiradoras",
  name: "PraticasInspiradoras",
  components: { main: () => import("@/pages/PraticasInspiradoras.vue")},
  meta: {
    requiresAuth: false,
    title: "Práticas Inspiradoras",
    layout: Default
  }
};

const canalAT = {
  path: "/canal-anisio-teixeira",
  name: "canalAT",
  components: { main: () => import("@/pages/CanalAT.vue") },
  meta: {
    requiresAuth: false,
    title: "Canal Anísio Teixeira",
    layout: Default
  }
};

export {
    homeRoute,
    galeriaRoute,
    sobreRoute,
    ipesRoute,
    rotinasRoute,
    canalAT,
    advancedSearch,
    praticasInspiradoras
};