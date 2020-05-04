<template>
  <div class="YL__toolbar-input-container row no-wrap justify-end bg-none" id="autocomplete-form">
    <q-select
      dense
      rounded 
      standout 
      clearable
      bottom-slots
      v-model="term"
      use-input
      option-value="id"
      option-label="name"
      stack-label
      stack-icon
      hide-dropdown-icon
      debounce="200"
      @filter="searchTerm"
      @new-value="add"
      @input="selectedInput"
      :options="options"
      :placeholder="`Buscar por ${label}`"
      :loading="loadingState"
      label-color="primary"
      :input-style= "{ color: '#000' }"
      bg-color="grey-4"
      class="col q-mt-md"
      style="with:100%;"
    >
     <template v-slot:append>
      <q-icon class="cursor-pointer" round flat name="search" @click="searchTerm" color="primary" />
      <q-btn color="primary" round flat icon="more_vert" aria-label="opções de busca">
      <q-menu cover auto-close>
        <q-list>
          <q-item clickable aria-label="buscar por palavra chave" @click="recommendationPer('tag')">
            <q-item-section >Buscar por palavra chave</q-item-section>
          </q-item>
          <q-item clickable aria-label="buscar por título" @click="recommendationPer('titulo')">
            <q-item-section >Buscar por título</q-item-section>
          </q-item>
          <q-item clickable aria-label="acessar busca avançada" @click="openDialog()">
            <q-item-section>Acessar busca avançada</q-item-section>
          </q-item>
        </q-list>
      </q-menu>
    </q-btn>
     </template>
    </q-select>

<!-- CÓDIGO ANTIGO AGUARDANDO LIVE PARA RESOLUÇÃO DE ERRO NA BUSCA --

    <q-btn 
      rounded
      outlined
      dense
      @click="searchTerm"
      class="YL__toolbar-input-btn"
      
      text-color="$primary"
      color="$primary"
      icon="search"
      unelevated
      aria-label="pesquisar"
    />
    <q-btn color="$primary" round flat icon="more_vert" aria-label="opções de busca">
      <q-menu cover auto-close>
        <q-list>
          <q-item clickable aria-label="sugerir por palavra chave" @click="recommendationPer('tag')">
            <q-item-section >Buscar por palavra chave</q-item-section>
          </q-item>
          <q-item clickable aria-label="sugerir por título" @click="recommendationPer('titulo')">
            <q-item-section >Buscar por título</q-item-section>
          </q-item>
          <q-item clickable aria-label="busca avançada" @click="openDialog()">
            <q-item-section>Acessar busca avançada</q-item-section>
          </q-item>
        </q-list>
      </q-menu>
    </q-btn>
    
-->

  </div>
</template>
<script>
import { QSelect } from "quasar";
import AdvancedSearchForm from "./AdvancedSearchForm.vue";

export default {
  name: "AutocompleteForm",
  components: { QSelect },
  data() {
    return {
      term: null,
      label: "palavra chave",
      options: [],
      per: "tag",
      loadingState: false
    };
  },
  methods: {
    searchTerm(val, update, abort) {
      const self = this;
      update(() => {
        if (val === "" || val.length <= 3) {
          self.options = [];
          self.loadingState = false;
        } else {
          self.loadingState = true;
          axios
            .get(`/autocompletar?termo=${val}&por=${this.per}`)
            .then(resp => {
              if (resp.data.success) {
                self.options = resp.data.paginator.data;
                self.loadingState = false;
              }
            });
        }
      });
    },
    selectedInput(value) {
      if (value) {
        this.$router.replace(
          `/recursos-educacionais/listar?busca=${value.name}`
        );
      } else {
        this.$router.replace(`/recursos-educacionais/listar`);
      }
    },
    add(details) {
      console.log(details);
    },
    recommendationPer(per) {
      this.per = per;
      if (per == "tag") {
        this.label = "palavra chave";
      } else {
        this.label = "título";
      }
    },
    openDialog() {
      this.$q.dialog({
        component: AdvancedSearchForm,
        parent: this
      });
    }
  }
};
</script>
<style lang="stylus" scoped>
.YL
  &__toolbar-input-container
    min-width: 100px
    width: 39% !important
  &__toolbar-input-btn
    border-radius: 0
    border-style: solid
    border-width: 1px 1px 1px 0
    border-color: rgba(0,0,0,.24)
    max-width: 60px
    width: 100%
    font-size: 16px !important
.q-btn
  font-size: 13px !important

@media (max-width: 680px)
  .YL
    &__toolbar-input-container
      min-width: 100px
      width: 100% !important
    &__toolbar-input-btn
      border-radius: 0
      border-style: solid
      border-width: 1px 1px 1px 0
      border-color: rgba(0,0,0,.24)
      max-width: 60px
      width: 100%
      font-size: 16px !important
  .q-btn 
    font-size: 13px !important

</style>
