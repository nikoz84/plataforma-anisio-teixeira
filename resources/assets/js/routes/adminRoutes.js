// @ts-nocheck
import { LoaderAdmin } from "@components/exibir";

const adminRoutes = {
  path: "/admin",
  name: "admin-home",
  component: () =>
    import(/* webpackChunkName: "admin" */ "@pages/Admin.vue"),
  meta: {
    requiresAuth: true
  },
  children: [
    {
      path: ":slug/:action/:id?",
      name: "admin",
      components: {
        default: LoaderAdmin,
        admin: LoaderAdmin
      },
      meta: {
        requiresAuth: true,
        title: "Administração"
      }
    }
  ]
};

export default adminRoutes;