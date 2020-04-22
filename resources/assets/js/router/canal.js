const canal =   {

    path: "/:slug",
    name: "Canal",
    component: () => import(/* webpackChunkName: "canal" */ "../pages/Canal.vue"),
    meta: {
        requiresAuth: false,
        title: "Canal Inicio"
    }

}

export default canal;
