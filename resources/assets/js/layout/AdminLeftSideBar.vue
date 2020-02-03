<template>
  <q-list>
    <q-item-label class="bg-grey-4" header>
      <div
        class="text-h6 text-primary"
        style="font-family: 'Concert One', sans-serif, cursive;"
      >
        Configurações
      </div>
    </q-item-label>
    <div v-for="(link, i) in links" :key="`admin-${i}`">
      <q-item
        tag="div"
        :to="{ name: link.view, params: link.params, path: '/admin' }"
        :aria-label="`endereço para: ${link.name}`"
        :title="`endereço para: ${link.name}`"
        clickable
        v-close-popup
        tabindex="0"
      >
        <q-item-section>
          <q-item-label>{{ link.label }}</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />
    </div>
  </q-list>
</template>
<script>
export default {
  name: "AdminLeftSideBar",
  data() {
    return {
      links: [
        {
          label: "Inicio",
          name: "inicio",
          view: "admin",
          params: { slug: "analytics", action: "listar" }
        },
        {
          label: "Aplicativos",
          name: "aplicativos",
          view: "admin",
          params: { slug: "aplicativos", action: "listar" }
        },
        {
          label: "Conteúdos",
          name: "conteudos",
          view: "admin",
          params: { slug: "conteudos", action: "listar" }
        },
        {
          label: "Canais",
          name: "canais",
          view: "admin",
          params: { slug: "canais", action: "listar" }
        },
        {
          label: "Tags",
          name: "tags",
          view: "admin",
          params: { slug: "tags", action: "listar" }
        },
        {
          label: "Usuários",
          name: "usuarios",
          view: "admin",
          params: { slug: "usuarios", action: "listar" }
        },
        {
          label: "Tipos",
          name: "admin",
          view: "admin",
          params: { slug: "tipos", action: "listar" }
        },
        {
          label: "Funções",
          name: "funcoes",
          view: "admin",
          params: { slug: "roles", action: "listar" }
        },
        {
          label: "Licenças",
          name: "licencas",
          view: "admin",
          params: { slug: "licencas", action: "listar" }
        },
        {
          label: "Denuncias",
          name: "denuncias",
          view: "admin",
          params: { slug: "denuncias", action: "listar" }
        }
      ]
    };
  }
};
</script>
