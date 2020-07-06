
const homeRoute = {
    path: "/",
    name: "Home",
    component: () => import(/* webpackChunkName: "home" */ "@pages/Home.vue"),
    meta: {
      requiresAuth: false,
      title: "Inicio"
    }
};
  
const galeriaRoute = {
    path: "/galeria",
    name: "Galeria",
    component: () => import(/* webpackChunkName: "galeria" */ "@components/home/Gallery.vue"),
    meta: {
      requiresAuth: false,
      title: "Galeria de Imagens"
    }
};
const sobreRoute = {
    path: "/sobre",
    name: "Sobre",
    component: () =>
      import(/* webpackChunkName: "sobre" */ "@pages/Sobre.vue"),
    meta: {
      requiresAuth: false,
      title: "Sobre a Plataforma"
    }
};
const praticasRoute = {
    path: "/praticas-pedagogicas",
    name: "PraticasPedagogicas",
    component: () =>
      import(/* webpackChunkName: "praticas" */ "@pages/PraticasPedagogicas.vue"),
    meta: {
      requiresAuth: false,
      title: "Pŕaticas pedagógicas"
    }
};
const ipesRoute = {
  path: "/ipes",
  name: "IpesFaculdades",
  component: () => import(/* webpackChunkName: "ipes" */ "@pages/Ipes.vue"),
  meta: {
      requiresAuth: false,
      title: "Faculdades da Bahia"
    }
};
const rotinasRoute = {
  path: "/rotinas-de-estudo",
  name: "RotinasEstudo",
  component: () => import(/* webpackChunkName: "rotinas" */ "@pages/RotinasDeEstudo.vue"),
  meta: {
      requiresAuth: false,
      title: "Rotinas de Estudo"
    }
};
export {
    homeRoute,
    galeriaRoute,
    sobreRoute,
    ipesRoute,
    rotinasRoute
};