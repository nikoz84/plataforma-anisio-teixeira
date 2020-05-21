
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
      import(/* webpackChunkName: "praticas" */ "../pages/PraticasPedagogicas.vue"),
    meta: {
      requiresAuth: false,
      title: "Pŕaticas pedagógicas"
    }
};

export {
    homeRoute,
    galeriaRoute,
    sobreRoute
};