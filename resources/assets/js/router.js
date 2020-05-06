import VueRouter from "vue-router";
import routes from "./routes";
import store from "./store";


const [routerPush, routerReplace] = [VueRouter.prototype.push, VueRouter.prototype.replace];
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error => error);
};
VueRouter.prototype.replace = function replace(location) {
  return routerReplace.call(this, location).catch(error => error);
};

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
      store.commit('SET_LOGOUT_USER');
      next("/usuario/login");
    }
  } else {
    next();
  }
});

export default router;
