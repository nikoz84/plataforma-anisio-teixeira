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
        <q-card-section class="col-4">
          <div class="text-h6 q-my-md">Filtros de busca</div>
          <!-- TIPO DE CONTEÚDOS -->
          <q-select
            option-value="id"
            option-label="name"
            transition-show="scale"
            transition-hide="scale"
            v-model="tiposModel"
            :options="tipos"
            multiple
            use-chips
            stack-label
            clearable
            hide-dropdown-icon
            standout="bg-primary text-white"
            label="Tipo de Conteúdo"
            behavior="dialog"
          />
          <q-separator></q-separator>
          <!-- LICENÇAS -->
          <q-select
            option-value="id"
            option-label="name"
            transition-show="scale"
            transition-hide="scale"
            v-model="licencasModel"
            :options="licencas"
            multiple
            use-chips
            stack-label
            clearable
            hide-dropdown-icon
            standout="bg-primary text-white"
            label="Licenças"
            behavior="dialog"
          />
          <q-separator></q-separator>
          <!-- COMPONENTES CURRICULARES -->
          <div class="q-my-md">Componentes Curriculares</div>
          <q-separator></q-separator>
          <div class="q-my-xs q-pt-sm q-pl-xs bg-dark text-white cursor-pointer open-sidebar-menu"
            v-for="(component, i) in componentes"
            :key="`c-${i}`"
            :index="component.id"
            >
            {{ component.name }}
          
            <q-menu anchor="top right" self="top left">
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
          <q-separator></q-separator>
          <!-- NIVEIS DE ENSINO -->
          <div class="q-my-md">Níveis de Ensino</div>
          <q-separator></q-separator>
          <div class="q-my-xs q-pt-sm q-pl-xs bg-dark text-white cursor-pointer open-sidebar-menu"
            v-for="(nivel, n) in niveis"
              :key="`n-${n}`"
              :index="nivel.id"
            >
            {{ nivel.name }}
          
            <q-menu anchor="top right" self="top left">
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
        <q-card-section class="col-9">
          <!-- PAGINATOR -->
          <div class="q-pa-sm flex flex-center">
            <q-pagination
              v-if="results.length > 0"
              v-model="current"
              :max="last"
              :input="true"
              @input="onSearch"
            >
          </q-pagination>
          </div>
          <!-- LISTA DE ITENS -->
          <div class="q-pa-sm">
            <q-card class="q-mt-sm" v-for="(item, i) in results" :key="`result-${i}`">
              <q-card-section>
                <a class="paginator-link" :href="item.url_exibir">
                  <h5 class="text-dark" v-html="item.title"></h5>
                </a>
                <p class="paginator-excerpt" v-html="item.excerpt"></p>
              </q-card-section>
            </q-card>
          </div>
          <!-- PAGINATOR -->
          <div class="q-pa-lg flex flex-center">
            <q-pagination
              v-if="results.length > 0"
              v-model="current"
              :max="last"
              :input="true"
              @input="onSearch"
            >
          </q-pagination>
        </div>
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
      niveisModel: [],
      results: [],
      current: 0,
      last: 0
    };
  },
  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis"]),
  },
  created() {
    this.onSearch();
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
    async onSearch() {
      //this.$emit("ok");

      
      let search = new URLSearchParams(location.search);
      search.set("tipos", this.tiposModel);
      search.set("licencas", this.licencasModel);
      search.set("componentes", this.componentesModel);
      search.set("per", this.per.value);
      search.set("page", this.current);
      search.set("busca", this.term);
      search.set("limit", this.limit.value);
      const {data} = await axios.get(`/conteudos?${search.toString()}`);
      this.results = data.paginator.data;
      this.last = data.paginator.last_page;
      this.current = data.paginator.current_page;
      console.log(data.paginator)
      
      //this.hide();
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
  min-height: 35px;
}
.paginator-link{
  font-size: 18px;
  font-weight: bold;
  &:hover{
    color: #066ab1;
  }
}
.paginator-excerpt{
  font-size: 18px;
}
</style>
