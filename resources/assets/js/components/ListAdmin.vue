<template>
  <article>
    <div :is="componentName"></div>
  </article>
</template>
<script>
import Table from "./Table.vue";
import { mapMutations, mapState } from "vuex";
import ConteudoForm from "../forms/ConteudoForm.vue";
import AplicativoForm from "../forms/AplicativoForm.vue";
import CanalForm from "../forms/CanalForm.vue";
import UserForm from "../forms/UserForm.vue";
import LicenseForm from "../forms/LicenseForm.vue";
import TagForm from "../forms/TagForm.vue";
import RoleForm from "../forms/RoleForm.vue";
import TipoForm from "../forms/TipoForm.vue";
import Resumo from "../pages/Resumo.vue";

export default {
  name: "Listar",
  components: {
    Table,
    aplicativos: AplicativoForm,
    conteudos: ConteudoForm,
    canais: CanalForm,
    usuarios: UserForm,
    licencas: LicenseForm,
    tags: TagForm,
    roles: RoleForm,
    tipos: TipoForm,
    Resumo
  },
  data() {
    return {
      componentName: ""
    };
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.getAction();
    });
  },
  watch: {
    $route: function() {
      this.getAction();
    }
  },
  methods: {
    getAction() {
      switch (true) {
        case this.$route.params.slug != "analytics" &&
          this.$route.params.action == "listar":
          this.componentName = "Table";
          break;
        case this.$route.params.action == "editar" ||
          this.$route.params.action == "adicionar":
          this.componentName = this.$route.params.slug;
          break;
        case this.$route.params.slug == "analytics":
          this.componentName = "Resumo";
          break;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
