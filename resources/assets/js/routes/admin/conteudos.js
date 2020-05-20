import { ConteudoAdmin } from "../../components/admin";
import ConteudoForm from "../../forms/ConteudoForm.vue";


const conteudosRoutes = [
    {
      path : 'slug',
      children: [
        {
          path: ":slug",
          name:"IndexConteudos",
          components: { 
              new_admin: ConteudoAdmin
          },
            meta: {
              requiresAuth: true,
              title: "Listar Conteúdos"
            }
        },
        {
            path: ":slug/:action/:id",
            name:"EditarConteudos",
            components: {
                new_admin: ConteudoForm
              },
              meta: {
                requiresAuth: true,
                title: "Editar Conteúdo"
              }
        },
        {
            path: ":slug/:action",
            name:"AdicionarConteudos",
            components: {
                new_admin: ConteudoForm
              },
              meta: {
                requiresAuth: true,
                title: "Adicionar Conteúdo"
              }
        }
      ]
    },
    
];

export default conteudosRoutes;