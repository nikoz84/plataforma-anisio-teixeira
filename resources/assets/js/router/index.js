import VueRouter from "vue-router";
import canal from './canal';
import home from './home';
import aplicativos from './aplicativos';
import blog from './blog';
import dashboard from './dashboard';

const routes = [
    home,
    aplicativos,
    dashboard,
    blog,
    canal,
]


const router = new VueRouter({
  mode: "history",
  routes
});



export default router;
