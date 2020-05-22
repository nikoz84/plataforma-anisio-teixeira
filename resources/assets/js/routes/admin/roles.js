import Table from "../../components/Table.vue";
import RoleForm from "../../forms/RoleForm.vue";

const rolesRoutes = [
    {
        path: "roles",
        name:"IndexRoles",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar tipos de usuário"
          }
    },
    {
        path: "roles/editar/:id",
        name:"EditarRoles",
        components: {
            new_admin: RoleForm
          },
          meta: {
            requiresAuth: true,
            title: "Editar tipo de usuário"
          }
    },
    {
        path: "roles/adicionar",
        name:"AdicionarRoles",
        components: {
            new_admin: RoleForm
          },
          meta: {
            requiresAuth: true,
            title: "Adicionar tipo de usuário"
          }
    }
];

export default rolesRoutes;