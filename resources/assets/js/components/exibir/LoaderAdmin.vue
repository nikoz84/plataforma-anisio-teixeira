<template>
  <article>
    <!--keep-alive -->
    <div :is="componentName"></div>
  </article>
</template>
<script>// @ts-nocheck

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
  OptionsForm,
  CategoryConteudoForm,
  CurricularComponentsForm,
  CurricularComponentsCategoryForm,
  NivelEnsinoForm,
  UniversidadesForm
  } from "@forms/models";

import Resumo from "@pages/Resumo.vue";
import { Contato }  from "@components/exibir";



export default {
  name: "Listar",
  components: {
    resumo: Resumo,
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
    //listar: Table,
    categorias:CategoryConteudoForm,
    componentes: CurricularComponentsForm,
    componentescategorias:CurricularComponentsCategoryForm,
    nivelensino:NivelEnsinoForm,
    universidades: UniversidadesForm
  },
  data() {
    return {
      componentName: ""
    };
  },
  beforeRouteEnter(to, from, next) {
    if(to.meta.requiresAuth) {
      next(vm => {
        if(vm.isLogged){
          vm.getAction();
        }
      });
    } else {
      this.SET_LOGOUT_USER()
      next("/usuario/login");
    }
  },
  watch: {
    $route: function() {
      this.getAction();
    }
  },
  computed:{
    ...mapState(["isLogged"])
  },
  methods: {
    ...mapMutations(["SET_LOGOUT_USER"]),
    getAction() {
      switch (true) {
        case this.$route.params.slug != "resumo" &&
          this.$route.params.action == "listar":
          this.componentName = "listar";
          break;
        case this.$route.params.action == "editar" ||
          this.$route.params.action == "adicionar":
          this.componentName = this.$route.params.slug;
          break;
        case this.$route.params.slug == "resumo":
          this.componentName = "resumo";
          break;
      }
    }
  }
};
</script>
