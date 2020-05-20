import Table from "../../components/Table.vue";
import AplicativoForm from "../../forms/AplicativoForm.vue";

const aplicativosRoutes = [
    {
        path: "aplicativos",
        name:"IndexAplicativos",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar Aplicativos"
          }
    },
    {
        path: "aplicativos/editar/:id",
        name:"EditarAplicativos",
        components: {
            new_admin: AplicativoForm
          },
          meta: {
            requiresAuth: true,
            title: "Editar Aplicativo"
          }
    },
    {
        path: "aplicativos/adicionar",
        name:"AdicionarAplicativos",
        components: {
            new_admin: AplicativoForm
          },
          meta: {
            requiresAuth: true,
            title: "Adicionar Aplicativo"
          }
    }
];


export default aplicativosRoutes;