import Admin from '@layout/Admin.vue'
const conteudosListar = {
      path: "/conteudos/listar",
      components: {
        admin: () => import('@components/exibir/ListarConteudos.vue'),
      },
      meta: {
        requiresAuth: true,
        title: "Listar Conteúdos",
        layout: Admin,
      },
}

export {
    conteudosListar
}