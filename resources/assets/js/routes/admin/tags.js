import Table from "../../components/Table.vue";
import TagForm from "../../forms/TagForm.vue";

const tagsRoutes = [
    {
        path: "tags",
        name:"IndexTags",
        components: { 
            new_admin: Table
        },
          meta: {
            requiresAuth: true,
            title: "Listar Palavras chave"
          }
    },
    {
        path: "tags/editar/:id",
        name:"EditarTags",
        components: {
            new_admin: TagForm
          },
          meta: {
            requiresAuth: true,
            title: "Editar Palavra chave"
          }
    },
    {
        path: "tags/adicionar",
        name:"AdicionarTags",
        components: {
            new_admin: TagForm
          },
          meta: {
            requiresAuth: true,
            title: "Adicionar Tag"
          }
    }
];

export default tagsRoutes;