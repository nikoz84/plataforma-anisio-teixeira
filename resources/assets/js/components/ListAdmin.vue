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
  } from "@/forms/models";

import SliderForm from '@/forms/SliderForm.vue';
import Resumo from "@/pages/Resumo.vue";
import Table from "./Table.vue";
import { Contato }  from "@/components/exibir";


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
    contato: Contato,
    SliderForm,
    listar: Table,
    Resumo,
    
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
          this.componentName = "Resumo";
          break;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
