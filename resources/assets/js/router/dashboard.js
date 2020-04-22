const dashboard = {
    path: "/admin",
    name: "Dashboard",
    component: () => import(/* webpackChunkName: "dashboard" */ "../pages/Dashboard.vue"),
    meta: {
      requiresAuth: true,
      title: "Configurações"
    },
    children: [

    ]
};

export default dashboard;
