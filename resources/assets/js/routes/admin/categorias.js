import Table from "../../components/Table.vue";

const categoriasRoutes = [
    {
        path: "categorias",
        name:"IndexCategorias",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar categorias"
          }
    }
];


export default categoriasRoutes;