

const aplicativos = {
    path: "/aplicativos-educacionais",
    name: "Aplicativos",
    component: () => import(/* webpackChunkName: "aplicativos" */ "../pages/Aplicativos.vue"),
    meta: {
      requiresAuth: false,
      title: "Aplicativos educacionais"
    }
};

export default aplicativos;
