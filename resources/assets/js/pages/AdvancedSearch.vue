<template>
  <div>
    <q-card>
        <q-card-section>
            <Title title="Busca Avançada de Recursos Educacionais"></Title>
        </q-card-section>
        <q-card-section>Estamos trabalhando para dar uma melhor experiência de busca</q-card-section>
    </q-card>
    <!--q-card>
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
            </q-input-->
            <!-- QUANTIDADE -->
        <!--q-select
          class="col-sm-1"
          dense
          v-model="limit"
          stack-label
          :options="perPageOptions"
          hint="Itens por Página"
        /-->
        <!-- SUGERÊNCIA -->
        <!--q-select
          class="col-sm-2"
          dense
          v-model="per"
          stack-label
          :options="perSearchOptions"
          hint="Sugerência por"
        /-->
        <!--/q-card-section-->
    <!--/q-card-->
    <!--q-card>
        <TabComponentes></TabComponentes>
    </q-card-->
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
        per: {label: 'Palavra Chave', value: 'tag' },
        limit: { label: "15 itens", value: 10 },
        perPageOptions: [
            { label: "10 itens", value: 10 },
            { label: "15 itens", value: 15 },
            { label: "20 itens", value: 20 }
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
        
        searchBy(per){
        let title = per == 'tag' ? 'por uma palavra chave' : 'por um título';
        this.per = per;
        this.hintSearch = `Procure ${title}`;
        },
        
        async onSearch() {
        
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
        
        
        },
        onCancelClick() {
            this.$router.replace(`/recursos-educacionais/listar`);
        }
    }
}
</script>
