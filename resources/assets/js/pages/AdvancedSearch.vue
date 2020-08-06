<template>
  <div class="q-pa-md">
    <q-card class="q-mb-sm">
        <q-card-section>
            <Title title="Busca Avançada de Recursos Educacionais"></Title>
        </q-card-section>
        <q-card-section class="row justify-center q-gutter-sm">
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
        <q-btn size="sm" @click="showFiltros = !showFiltros">
            {{ showFiltros ? 'Esconder Filtros' : 'Filtros' }}
        </q-btn>
        </q-card-section>
    </q-card>
    <q-card class="q-mb-xs" v-if="filtros">
        <q-card-section>
            Termo: <q-chip size="sm">{{ term ? term : 'Faça uma pesquisa' }}</q-chip> 
            Sugerir por: <q-chip size="sm">{{ per.label }}</q-chip> 
            Quantidade de itens por página: <q-chip size="sm">{{limit.value}}</q-chip>
        </q-card-section>
        <q-card-section v-if="filtros && filtros.tipos && filtros.tipos.length > 0">
            Tipo de Conteúdo:
            <q-chip size="sm" v-for="(tipo, i) in filtros.tipos" :key="`${i}-filtro-tipo`">
                {{ tipo.name }}
            </q-chip>
        </q-card-section>
        <q-card-section v-if="filtros && filtros.licencas && filtros.licencas.length > 0">
            Tipo de Licença:
            <q-chip size="sm" v-for="(licenca, i) in filtros.licencas" :key="`${i}-filtro-licenca`">
                {{ licenca.name }}
            </q-chip>
        </q-card-section>
        <q-card-section v-if="filtros && filtros.componentes && filtros.componentes.length > 0">
            Componentes Curriculares:
            <q-chip size="sm" v-for="(componente, i) in filtros.componentes" :key="`${i}-filtro-componente`">
                {{ componente.name }}
            </q-chip>
        </q-card-section>
    </q-card>
    <q-card v-if="showFiltros">
        <TabComponentes @setFiltros="setFiltros"></TabComponentes>
    </q-card>
    <q-card>
        <q-card-section >
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
              <q-card-section class="q-px-sm">
                <h5 class="text-dark q-my-xs" v-html="item.title"></h5>
                <q-separator class="q-my-md"></q-separator>
                <div class="paginator-excerpt" v-html="item.excerpt"></div>
              </q-card-section>
              <q-card-actions vertical align="right">
                  <q-btn color="pink-9" type="a" target="__blank" :href="item.url_exibir">Visualizar</q-btn>
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
        </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { TabComponentes, Title } from "@components/shared";
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
    name: "AdvancedSearch",
    components: {
        TabComponentes,
        QList,
        Title,
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
        per: { label: 'Palavra Chave', value: 'tag' },
        limit: { label: "6 itens", value: 6 },
        perPageOptions: [
            { label: "6 itens", value: 6 },
            { label: "12 itens", value: 12 },
            { label: "18 itens", value: 18 }
        ],
        perSearchOptions: [
            {label: 'Palavra Chave', value: 'tag' },
            {label: 'Título', value: 'titulo' }
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
        filtros: []
        };
    },
    computed: {
        ...mapState(["tipos", "licencas", "componentes", "niveis"]),
    },
    created() {
        this.onSearch();
    },
    watch: {
        tiposModel: function (old, newbie) {
            this.onSearch();
        },
        licencasModel: function (old, newbie) {
            this.onSearch();
        },
        componentesModel: function (old, newbie) {
            this.onSearch();
        },
    },
    methods: {
        
        searchBy(per){
        let title = per == 'tag' ? 'por uma palavra chave' : 'por um título';
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
        const {data} = await axios.get(`/conteudos?${search.toString()}`);
        this.$q.loading.hide();
        this.results = data.paginator.data;
        this.last = data.paginator.last_page;
        this.current = data.paginator.current_page;
        
        },
        onCancelClick() {
            this.$router.replace(`/recursos-educacionais/listar`);
        },
        setFiltros(data){
            this.filtros = data;
            this.licencasModel = data.licencas.map(item => item.id);
            this.tiposModel = data.tipos.map(item => item.id);
            this.componentesModel = data.componentes.map(item => item.id);
            
        }

    }
}
</script>
