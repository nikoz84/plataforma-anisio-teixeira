import Table from "../../components/Table.vue";

const usuariosRoutes = [
    {
        path: "usuarios",
        name:"IndexUsuarios",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar usuários"
          }
    }
];


export default usuariosRoutes;