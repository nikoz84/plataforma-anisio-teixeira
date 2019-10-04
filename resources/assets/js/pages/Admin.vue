<template>
  <div class="row">
      <header class="page-header col-12">
        <div class="page-title text-h6 text-center q-pa-lg">
            Administração da Plataforma
        </div>
        <nav>
          <q-tabs inline-label class="bg-primary text-white shadow-2">
              
              <q-route-tab v-for="(link,i) in links"
                    :key="`links+${i}`"
                    :label="link.label" 
                    :to="{ name:link.view, params: link.params, path: '/admin'}"
                    />
              <q-separator vertical inset />
              
          </q-tabs>
        </nav>
      </header>
      <section class="col-12">
          <router-view name="admin"></router-view>
      </section>
  </div>
</template>
<script>
import { mapState } from "vuex";
import { QTabs, QRouteTab, QSeparator } from "quasar";

export default {
  name: "admin",
  components: {
    QTabs,
    QRouteTab,
    QSeparator
  },
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
        }
      ]
    };
  }
};
</script>
<style lang="scss" scoped>
.page-header {
  margin-top: 0px;
}
</style>

