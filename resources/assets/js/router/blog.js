const blog = {
    path: "/blog",
    name: "Blog",
    component: () => import(/* webpackChunkName: "blog" */ "../pages/Blog.vue"),
    meta: {
      requiresAuth: false,
      title: "Blog da Rede"
    },
    children: [

    ]
};

export default blog;
