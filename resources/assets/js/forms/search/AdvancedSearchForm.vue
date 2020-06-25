<template>
  <q-dialog
    ref="dialog"
    @hide="onDialogHide"
    persistent
    :maximized="true"
    transition-show="slide-up"
    transition-hide="slide-down"
  >
    <q-card>
      <q-bar class="bg-dark text-white">
        Busca avançada de recursos educacionais
        <q-space />
        <q-btn flat icon="close" v-close-popup aria-label="fechar">
          <q-tooltip content-class="bg-dark text-white">Fechar</q-tooltip>
        </q-btn>
      </q-bar>
      <q-card-section class="row justify-center q-gutter-sm">
        <!-- BUSCA -->
        <q-input
          class="col-sm-4 input-search"
          v-model="term"
          filled
          dense
          clearable
          clear-icon="close"
          :hint="hintSearch"
          bottom-slots
        >
          <template v-slot:prepend>
            <q-icon name="article" />
          </template>
          <template v-slot:append>
            <q-icon color="secondary" name="search" @click="onSearch" class="cursor-pointer" label="Pesquisar"/>
          </template>
        </q-input>
        <!-- QUANTIDADE -->
        <q-select
          class="col-sm-1"
          dense
          v-model="limit"
          stack-label
          :options="perPageOptions"
          hint="Itens por Página"
        />
        <!-- SUGERÊNCIA -->
        <q-select
          class="col-sm-2"
          dense
          v-model="per"
          stack-label
          :options="perSearchOptions"
          hint="Sugerência por"
        />
        
      </q-card-section>
      <q-card-section horizontal>
        <!-- COMPONENTES -->
        <q-card-section class="col-4">
          <!-- TIPOS DE CONTEUDOS -->
          <div class="row flex-center q-mt-xs bg-secondary text-white cursor-pointer open-sidebar-menu">
            Tipos de Conteúdos
            <q-menu anchor="bottom middle" self="top middle">
              <div class="row no-wrap q-pa-md">
                <div class="column">
                    <q-checkbox
                      tag="label"
                      v-for="(tipo, i) in tipos"
                      :key="`t-${i}`"
                      v-model="tiposModel"
                      :val="tipo.id"
                      :label="tipo.name"
                      color="orange"
                    />
                </div>
              </div>
            </q-menu>
          </div>
          <q-separator></q-separator>
          <!-- LICENCAS -->
          <div class="row flex-center q-mt-xs bg-secondary text-white cursor-pointer open-sidebar-menu">
            Licenças
            <q-menu anchor="bottom middle" self="top middle">
              <div class="row no-wrap q-pa-md">
                <div class="column">
                    <q-checkbox
                      tag="label"
                      v-for="(license, l) in licencas"
                      :key="`l-${l}`"
                      v-model="licencasModel"
                      :val="license.id"
                      :label="license.name"
                      color="orange"
                    />
                </div>
              </div>
            </q-menu>
          </div>
          <q-separator></q-separator>
          <!-- COMPONENTES CURRICULARES -->
          <div class="row flex-center q-mt-xs bg-secondary text-white cursor-pointer open-sidebar-menu"
            v-for="(component, i) in componentes"
            :key="`c-${i}`"
            :index="component.id"
            >
            {{ component.name }}
          
            <q-menu anchor="bottom middle" self="top middle">
              <div class="row no-wrap q-pa-md">
                <div class="column">
                    <q-checkbox
                      dense
                      class="q-my-sm"
                      v-for="(component, i) in component.componentes"
                      :key="`child-com-${i}`"
                      v-model="componentesModel"
                      :val="component.id"
                      :label="component.name"
                    />
                </div>
              </div>
            </q-menu>
          </div>
          <!-- NIVEIS DE ENSINO -->
          <div class="row flex-center q-mt-xs bg-secondary text-white cursor-pointer open-sidebar-menu"
            v-for="(nivel, n) in niveis"
              :key="`n-${n}`"
              :index="nivel.id"
            >
            {{ nivel.name }}
          
            <q-menu anchor="bottom middle" self="top middle">
              <div class="row no-wrap q-pa-md">
                <div class="column">
                    <q-checkbox
                      dense
                      class="q-my-sm"
                      v-for="(component, i) in nivel.componentes"
                      :key="`child-com-${i}`"
                      v-model="componentesModel"
                      :val="component.id"
                      :label="component.name"
                      color="teal"
                    />
                </div>
              </div>
            </q-menu>
          </div>
        </q-card-section>
        <q-separator vertical />
        <q-card-section class="col-6">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        </q-card-section>
      </q-card-section>

    </q-card>
  </q-dialog>
</template>
<script>
import { mapState } from "vuex";

import {
  QList,
  QItem,
  QItemSection,
  QCheckbox,
  QInput,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QSeparator,
  QRadio,
  QSelect
} from "quasar";
export default {
  name: "AdvancedSearchForm",
  components: {
    QList,
    QItem,
    QItemSection,
    QCheckbox,
    QInput,
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QSeparator,
    QRadio,
    QSelect
  },
  data() {
    return {
      term: "",
      hintSearch: 'Procure por uma palavra chave',
      per: {label: 'Palavra Chave', value: 'tag' },
      limit: { label: "15 itens", value: 15 },
      perPageOptions: [
        { label: "15 itens", value: 15 },
        { label: "30 itens", value: 30 },
        { label: "45 itens", value: 45 }
      ],
      perSearchOptions: [
        {label: 'Palavra Chave', value: 'tag' },
        {label: 'Título', value: 'titulo' }
      ],
      maximizedToggle: true,
      tiposModel: [],
      licencasModel: [],
      componentesModel: [],
      niveisModel: []
    };
  },
  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis"]),
  },
  methods: {
    show() {
      this.$refs.dialog.show();
    },
    searchBy(per){
      let title = per == 'tag' ? 'por uma palavra chave' : 'por um título';
      this.per = per;
      this.hintSearch = `Procure ${title}`;
    },
    hide() {
      this.$refs.dialog.hide();
    },
    onDialogHide() {
      this.$emit("hide");
    },
    onSearch() {
      this.$emit("ok");

      let params = {
        tipos: this.tiposModel,
        componentes: this.componentesModel,
        licencas: this.licencasModel
      };
      let search = new URLSearchParams(location.search);
      search.set("tipos", this.tiposModel);
      search.set("licencas", this.licencasModel);
      search.set("componentes", this.componentesModel);
      search.set("per", this.per);
      search.set("busca", this.term);
      search.set("limit", this.limit.value);

      this.$parent.$router.replace(
        `/recursos-educacionais/listar?${search.toString()}`
      );

      this.hide();
    },
    onCancelClick() {
      this.$parent.$router.replace(`/recursos-educacionais/listar`);
      this.hide();
    }
  }
};
</script>
<style lang="stylus" scoped>
.input-search {
  width: 50%;
}
.open-sidebar-menu{
  width: 100%; 
  min-height: 45px;
}
</style>
