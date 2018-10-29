import HomeCanal from './pages/HomeCanal.vue';
import Sobre from './pages/Sobre.vue';
import Listar from './pages/Listar.vue';
import Exibir from './pages/Exibir.vue';
import Formulario from './forms/ConteudoForm.vue';

const routes =[
    {
      path: '/',
      name: 'Home',
      component: () => import(/* webpackChunkName: "home" */ './pages/Home.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/admin',
      name: 'Admin',
      component: () => import(/* webpackChunkName: "admin" */ './pages/Admin.vue'),
      meta: {
        requiresAuth: true,
        //is_admin : true
      }
    },    
    {
      path: '/login',
      name: 'Login',
      component: () => import(/* webpackChunkName: "login" */ './pages/Login.vue'),
      meta: {
        requiresAuth: false,
        guest: true
      }
    },
    {
      path: '/:slug',
      name: 'Canal',
      component: () => import(/* webpackChunkName: "canal" */ './pages/Canal.vue'),
      meta: {
        requiresAuth: false
      },
      children: [
        {
          path: 'inicio',
          name: 'Inicio',
          component: HomeCanal
        },
        {
          path: 'sobre',
          name: 'Sobre',
          component: Sobre
        },
        {
          path: 'listar',
          name: 'Listar',
          component: Listar
        },
        {
          path: 'exibir',
          name: 'Exibir',
          component: Exibir
        },
        {
          path: 'formulario',
          name: 'Formulario',
          component: Formulario
        }


      ]
    }
];


export default routes;
