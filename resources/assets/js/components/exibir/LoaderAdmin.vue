<template>
  <article>
    <div :is="componentName"></div>
  </article>
</template>
<script>
import { mapMutations, mapState } from "vuex";
import { 
  ConteudoForm,
  AplicativoForm,
  CanalForm,
  UserForm,
  LicenseForm,
  TagForm,
  RoleForm,
  TipoForm,
  OptionsForm
  } from "@forms/models";

import Resumo from "@pages/Resumo.vue";
import { Contato, Table }  from "@components/exibir";


export default {
  name: "Listar",
  components: {
    aplicativos: AplicativoForm,
    conteudos: ConteudoForm,
    canais: CanalForm,
    usuarios: UserForm,
    licencas: LicenseForm,
    tags: TagForm,
    roles: RoleForm,
    tipos: TipoForm,
    options: OptionsForm,
    contato: Contato,
    listar: Table,
    resumo: Resumo,
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
          this.componentName = "listar";
          break;
        case this.$route.params.action == "editar" ||
          this.$route.params.action == "adicionar":
          this.componentName = this.$route.params.slug;
          break;
        case this.$route.params.slug == "analytics":
          this.componentName = "resumo";
          break;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
