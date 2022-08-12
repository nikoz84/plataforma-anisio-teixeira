
const homeRoute = {
    path: "/",
    name: "Home",
    components: { default: () => import("@/pages/Home.vue"), main: () => import("@/pages/Home.vue") },
    meta: {
      requiresAuth: false,
      title: "Inicio",
      layout: () => import("@/layout/Default.vue")
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
      layout: () => import("@/layout/Default.vue")
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
      layout: () => import("@/layout/Default.vue") 
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
      layout: () => import("@/layout/Default.vue")
    }
};

const ipesRoute = {
  path: "/ipes",
  name: "IpesFaculdades",
  components: { main : () => import("@/pages/Ipes.vue")},
  meta: {
      requiresAuth: false,
      title: "Faculdades da Bahia",
      layout: () => import("@/layout/Default.vue")
    }
};
const rotinasRoute = {
  path: "/rotinas-de-estudo/:nivel?/:semana?",
  name: "RotinasEstudo",
  components: { main : () => import("@/pages/RotinasDeEstudo.vue")},
  meta: {
      requiresAuth: false,
      title: "Rotinas de Estudo",
      layout: () => import("@/layout/Default.vue")
    }
};

const advancedSearch = {
  path: "/busca-avancada",
  name: "BuscaAvancada",
  components: { main: () => import("@/pages/AdvancedSearch.vue")},
  meta: {
      requiresAuth: false,
      title: "Busca Avançada",
      layout: () => import("@/layout/Default.vue")
    }
};


const praticasInspiradoras = {
  path: "/praticas-inspiradoras",
  name: "PraticasInspiradoras",
  components: { main: () => import("@/pages/PraticasInspiradoras.vue")},
  meta: {
    requiresAuth: false,
    title: "Práticas Inspiradoras",
    layout: () => import("@/layout/Default.vue")
  }
};

const canalAT = {
  path: "/canal-anisio-teixeira",
  name: "canalAT",
  components: { main: () => import("@/pages/CanalAT.vue") },
  meta: {
    requiresAuth: false,
    title: "Canal Anísio Teixeira",
    layout: () => import("@/layout/Default.vue")
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