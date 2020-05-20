import Table from "../../components/Table.vue";

const licencasRoutes = [
    {
        path: "licencas",
        name:"IndexLicencas",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar licenças"
          }
    }
];


export default licencasRoutes;