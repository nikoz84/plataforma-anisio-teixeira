<template>
  <div class="q-pa-md">
    <q-card class="q-mb-sm">
      <q-card-section>
        <Title title="Busca Avançada de Recursos Educacionais"></Title>
      </q-card-section>
      <q-card-section class="row justify-center q-gutter-md">
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
            <q-icon
              color="secondary"
              name="search"
              @click="onSearch"
              class="cursor-pointer"
              label="Pesquisar"
            />
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
        >
        </q-select>
        <q-btn
          icon-right="filter_list"
          size="md"
          color="primary"
          class="text-dark"
          stack
          glossy
          @click="showFiltros = !showFiltros"
        >
          {{ showFiltros ? "Esconder Filtros" : "Exibir Filtros" }}
        </q-btn>
      </q-card-section>
    </q-card>
    <q-card class="q-mb-xs" v-if="showFiltros">
      <TabComponentes @setFiltros="setFiltros"></TabComponentes>
    </q-card>
    <q-card class="q-mb-xs" v-if="filtros">
      <q-card-section>
        Termo:
        <q-chip size="md">{{ term ? term : "Faça uma pesquisa" }}</q-chip>
        Sugerir por: <q-chip size="md">{{ per.label }}</q-chip> Quantidade de
        itens por página: <q-chip size="md">{{ limit.value }}</q-chip>
      </q-card-section>
      <q-card-section
        v-if="filtros && filtros.tipos && filtros.tipos.length > 0"
      >
        Tipo de Conteúdo:
        <q-chip
          removable
          size="md"
          v-for="(tipo, i) in filtros.tipos"
          @remove="
            filtros.tipos.splice(i, 1);
            tiposModel.splice(i, 1);
            onSearch();
          "
          :key="`${i}-filtro-tipo`"
        >
          {{ tipo.name }}
        </q-chip>
      </q-card-section>
      <q-card-section
        v-if="filtros && filtros.licencas && filtros.licencas.length > 0"
      >
        Tipo de Licença:
        <q-chip
          removable
          size="md"
          v-for="(licenca, i) in filtros.licencas"
          @remove="
            filtros.licencas.splice(i, 1);
            licencasModel.splice(i, 1);
            onSearch();
          "
          :key="`${i}-filtro-licenca`"
        >
          {{ licenca.name }}
        </q-chip>
      </q-card-section>
      <q-card-section
        v-if="filtros && filtros.componentes && filtros.componentes.length > 0"
      >
        Componentes Curriculares:
        <q-chip
          removable
          size="md"
          v-for="(componente, i) in filtros.componentes"
          @remove="
            filtros.componentes.splice(i, 1);
            componentesModel.splice(i, 1);
            onSearch();
          "
          :key="`${i}-filtro-componente`"
        >
          {{ componente.name }}
        </q-chip>
      </q-card-section>
    </q-card>

    <div class="q-pa-lg">
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
        <q-card
          class="q-mt-sm"
          v-for="(item, i) in results"
          :key="`result-${i}`"
        >
          <q-card-section class="q-px-sm">
            <a :href="item.url_exibir" target="new" class="text-dark">
              <h5 class="q-my-xs" v-html="item.title"></h5>
            </a>
            <q-separator class="q-my-md"></q-separator>
            <div class="paginator-excerpt" v-html="item.description"></div>
          </q-card-section>
          <q-card-actions vertical align="right">
            <!--q-btn color="pink-9" type="a" target="_blank" :href="item.url_exibir">Visualizar</q-btn-->
          </q-card-actions>
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
    </div>
  </div>
</template>

<script>
import { TabComponentes, Title } from "../components/shared";
import { mapState } from "vuex";

export default {
  name: "AdvancedSearch",
  components: {
    TabComponentes,
    Title,
  },
  data() {
    return {
      term: "",
      hintSearch: "Procure por uma palavra chave",
      per: { label: "Palavra Chave", value: "tag" },
      limit: { label: "6 itens", value: 6 },
      perPageOptions: [
        { label: "6 itens", value: 6 },
        { label: "12 itens", value: 12 },
        { label: "18 itens", value: 18 },
      ],
      perSearchOptions: [
        { label: "Palavra Chave", value: "tag" },
        { label: "Título", value: "titulo" },
      ],
      showFiltros: false,
      maximizedToggle: true,
      licencasModel: [],
      tiposModel: [],
      componentesModel: [],
      niveisModel: [],
      results: [],
      current: 0,
      last: 0,
      filtros: [],
    };
  },
  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis"]),
  },
  created() {
    this.onSearch();
  },
  watch: {
    tiposModel: function(old, newbie) {
      this.onSearch();
    },
    licencasModel: function(old, newbie) {
      this.onSearch();
    },
    componentesModel: function(old, newbie) {
      this.onSearch();
    },
  },
  methods: {
    searchBy(per) {
      let title = per == "tag" ? "por uma palavra chave" : "por um título";
      this.per = per;
      this.hintSearch = `Procure ${title}`;
    },

    async onSearch() {
      this.$q.loading.show();
      let search = new URLSearchParams(location.search);
      search.set("tipos", this.tiposModel);
      search.set("licencas", this.licencasModel);
      search.set("componentes", this.componentesModel);
      search.set("per", this.per.value);
      search.set("page", this.current);
      search.set("busca", this.term);
      search.set("limit", this.limit.value);
      const { data } = await axios.get(`/conteudos?${search.toString()}`);
      this.$q.loading.hide();
      this.results = data.paginator.data;
      this.last = data.paginator.last_page;
      this.current = data.paginator.current_page;
    },
    onCancelClick() {
      this.$router.replace(`/recursos-educacionais/listar`);
    },
    setFiltros(data) {
      this.filtros = data;
      this.licencasModel = data.licencas.map((item) => item.id);
      this.tiposModel = data.tipos.map((item) => item.id);
      this.componentesModel = data.componentes.map((item) => item.id);
    },
  },
};
</script>
<style lang="stylus" scoped>
a:visited{
    color: rgb(123, 31, 162) !important /** purple-8 na collor pallete do quasar */
}
</style>
