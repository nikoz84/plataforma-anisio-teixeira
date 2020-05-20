import ListAdmin from "@/components/ListAdmin.vue";

const adminRoutes = {
  path: "/admin",
  name: "admin-home",
  component: () =>
    import(/* webpackChunkName: "admin" */ "@/pages/Admin.vue"),
  meta: {
    requiresAuth: true
  },
  children: [
    {
      path: ":slug/:action/:id?",
      name: "admin",
      components: {
        default: ListAdmin,
        admin: ListAdmin
      },
      meta: {
        requiresAuth: true,
        title: "Administração"
      }
    }
  ]
};

export default adminRoutes;