import Table from "../../components/Table.vue";
import CanalForm from "../../forms/CanalForm.vue";

const canaisRoutes = [
    {
        path: "canais",
        name:"IndexCanais",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar canais"
          }
    },
    {
        path: "canais/editar/:id",
        name:"EditarCanais",
        components: {
            new_admin: CanalForm
          },
          meta: {
            requiresAuth: true,
            title: "Editar canal"
          }
    },
    {
        path: "canais/adicionar",
        name:"AdicionarCanais",
        components: {
            new_admin: CanalForm
          },
          meta: {
            requiresAuth: true,
            title: "Adicionar canal"
          }
    }
];

export default canaisRoutes;