// @ts-nocheck
import Default from "@layout/Default";
import Home from "@pages/Home";


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
      main: () => import(/* webpackChunkName: "sobre" */ "@components/home/Gallery.vue")
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
      main : () => import(/* webpackChunkName: "sobre" */ "@pages/Sobre.vue")
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
    component: () => import(/* webpackChunkName: "praticas" */ "@pages/PraticasPedagogicas.vue"),
    meta: {
      requiresAuth: false,
      title: "Pŕaticas pedagógicas",
      layout: Default
    }
};
const ipesRoute = {
  path: "/ipes",
  name: "IpesFaculdades",
  components: { main: () => import(/* webpackChunkName: "ipes" */ "@pages/Ipes.vue")},
  meta: {
      requiresAuth: false,
      title: "Faculdades da Bahia",
      layout: Default
    }
};
const rotinasRoute = {
  path: "/rotinas-de-estudo/:nivel?/:semana?",
  name: "RotinasEstudo",
  components: { main : () => import(/* webpackChunkName: "rotinas" */ "@pages/RotinasDeEstudo.vue")},
  meta: {
      requiresAuth: false,
      title: "Rotinas de Estudo",
      layout: Default
    }
};

const advancedSearch = {
  path: "/busca-avancada",
  name: "BuscaAvancada",
  components: { main: () => import(/* webpackChunkName: "busca" */ "@pages/AdvancedSearch.vue")},
  meta: {
      requiresAuth: false,
      title: "Busca Avançada",
      layout: Default
    }
};

export {
    homeRoute,
    galeriaRoute,
    sobreRoute,
    ipesRoute,
    rotinasRoute,
    advancedSearch
};