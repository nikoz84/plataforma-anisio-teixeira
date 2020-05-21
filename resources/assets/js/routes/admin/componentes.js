import Table from "../../components/Table.vue";

const componentesRoutes = [
    {
        path: "componentes",
        name:"IndexComponentes",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar componentes curriculares"
          }
    }
];


export default componentesRoutes;