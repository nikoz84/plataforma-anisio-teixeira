import Table from "../../components/Table.vue";
import TipoForm from "../../forms/TipoForm.vue";

const tiposRoutes = [
    {
        path: "tipos",
        name:"IndexTipos",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar tipos de Conteúdos"
          }
    },
    {
        path: "tipos/editar/:id",
        name:"EditarTipos",
        components: {
            new_admin: TipoForm
          },
          meta: {
            requiresAuth: true,
            title: "Editar tipo de conteúdo"
          }
    },
    {
        path: "tipos/adicionar",
        name:"AdicionarTipos",
        components: {
            new_admin: TipoForm
          },
          meta: {
            requiresAuth: true,
            title: "Adicionar tipo de conteúdo"
          }
    }
];

export default tiposRoutes;