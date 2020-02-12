import VueRouter from "vue-router";
import routes from "./routes";
import store from "./store";

const router = new VueRouter({
  mode: "history",
  routes
});

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} - Plataforma Anísio Texeira`;
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // You can use store variable here to access globalError or commit mutation
    if (store.state.isLogged) {
      next();
    } else {
      next("/usuario/login");
    }
  } else {
    next();
  }
});

export default router;
