import Table from "../../components/Table.vue";

const contatoRoutes = [
    {
        path: "contato",
        name:"IndexContatos",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar fale conosco"
          }
    }
];


export default contatoRoutes;