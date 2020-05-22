import Table from "../../components/Table.vue";

const optionsRoutes = [
    {
        path: "options",
        name:"IndexOptions",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar Opções"
          }
    }
];


export default optionsRoutes;