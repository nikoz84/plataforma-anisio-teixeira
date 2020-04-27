<template>
  <div class="YL__toolbar-input-container row no-wrap justify-end" id="autocomplete-form">
    
    <q-select
      dense
      outlined
      square
      clearable
      v-model="term"
      use-input
      option-value="id"
      option-label="name"
      stack-label
      hide-dropdown-icon
      debounce="300"
      @filter="searchTerm"
      @new-value="add"
      @input="selectedInput"
      :options="options"
      :label="`Buscar por: ${label}`"
      :loading="loadingState"
      label-color="pink-5"
      bg-color="grey-4"
      class="grey-11 col"
      style="with:100%;"
      
    />

    <q-btn
      rounded
      outlined
      dense
      @click="searchTerm"
      class="YL__toolbar-input-btn"
      color="grey-3"
      text-color="pink-5"
      icon="search"
      unelevated
      aria-label="pesquisar"
    />
    <q-btn color="pink-5" round flat icon="more_vert" aria-label="opções de busca">
      <q-menu cover auto-close>
        <q-list>
          <q-item clickable aria-label="sugerir por palavra chave" @click="recommendationPer('tag')">
            <q-item-section >Sugerência por palavra chave</q-item-section>
          </q-item>
          <q-item clickable aria-label="sugerir por título" @click="recommendationPer('titulo')">
            <q-item-section >Sugerência por título</q-item-section>
          </q-item>
          <q-item clickable aria-label="busca avançada" @click="openDialog()">
            <q-item-section>Busca avançada</q-item-section>
          </q-item>
        </q-list>
      </q-menu>
    </q-btn>
    
  </div>
</template>
<script>
import AdvancedSearchForm from "./AdvancedSearchForm.vue";

export default {
  name: "AutocompleteForm",
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
    width: 45%
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
