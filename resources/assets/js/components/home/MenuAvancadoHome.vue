<template>
  <div class="q-pa">
    <q-card class=" background_busca_avancada">
      <q-card-section class="background_busca_avancada">
        <Title
          class="text-center"
          title="Busca Avançada de Recursos Educacionais"
        ></Title>
      </q-card-section>

    </q-card>
    <q-card class="q-mb-xs">
      <TabComponentesHome @setFiltros="setFiltros"></TabComponentesHome>
    </q-card>

    <q-card
      class="q-pa-md"
      v-if="filtros"
    >
      <div class="row">
        <div
          class="text-h5 title-page text-primary separatriz col"
          style="
    padding-top: 10px;
    padding-left: 10px;
"
        >
          Opções para a listagem atual

        </div>
        <div class="col">
          <!-- QUANTIDADE -->
          <q-select
            class="col"
            dense
            v-model="limit"
            stack-label
            :options="perPageOptions"
            hint="Itens por Página"
            @input="onSearch()"
          />
        </div>
      </div>
      <div class="separatriz-6"></div>

      <q-card-section v-if="filtros && filtros.tipos && filtros.tipos.length > 0">
        <b>Tipo de Conteúdo:</b>
        <q-chip
          removable
          size="md"
          v-for="(tipo, i) in filtros.tipos"
          @remove="filtros.tipos.splice(i, 1); tiposModel.splice(i,1); onSearch()"
          :key="`${i}-filtro-tipo`"
          text-color="white"
          color="pink-9"
        >
          {{ tipo.name }}
        </q-chip>
      </q-card-section>
      <q-card-section v-if="filtros && filtros.licencas && filtros.licencas.length > 0">
        <b> Tipo de Licença:</b>
        <q-chip
          removable
          size="md"
          v-for="(licenca, i) in filtros.licencas"
          @remove="filtros.licencas.splice(i, 1); licencasModel.splice(i,1); onSearch()"
          :key="`${i}-filtro-licenca`"
          text-color="white"
          color="teal"
        >
          {{ licenca.name }}
        </q-chip>
      </q-card-section>
      <q-card-section v-if="filtros && filtros.componentes && filtros.componentes.length > 0">
        <b> Componentes Curriculares:</b>
        <q-chip
          removable
          size="md"
          v-for="(componente, i) in filtros.componentes"
          @remove="filtros.componentes.splice(i, 1); componentesModel.splice(i,1); onSearch()"
          :key="`${i}-filtro-componente`"
          text-color="white"
          color="deep-purple-9"
        >
          {{ componente.name }}
        </q-chip>

      </q-card-section>

    </q-card>

    <q-chip
      color="negative"
      text-color="white"
      :label="`Quantidade de Itens Encontrados: ${total}`"
    />

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

        <q-card-section
          horizontal
          id="section_card_home"
        >

          <router-link
            :to="item.url_exibir"
            id="imagem"
            target="_blank"
          >
            <q-img
              href=""
              class="cursor-pointer hide_image"
              v-ripple
              alt="imagem destacada"
              :src="item.image"
              loading="lazy"
              width="300px"
              height="auto"
              :style="`
    min-width:auto;
    min-height: 230px;
    border-bottom: 5px solid #264b8f;
    border-top: 5px solid #264b8f;
    
    margin-left: 20px;
    margin-right: 20px;
    margin-top: 20px;
    border-radius: 6px;
  
    
    
    `"
              placeholder-src="/img/fundo-padrao.svg"
            >

              {{ /* Condicional dos recursos educacionais */ }}

            </q-img>
          </router-link>

          <q-card-section class="q-pa-sm">

            <router-link
              :to="item.url_exibir"
              class="text-dark"
              target="_blank"
            >
              <h5
                class="q-my-xs"
                v-html="item.title"
              ></h5>
            </router-link>

            <q-separator class="q-my-md"></q-separator>
            <div
              class="paginator-excerpt"
              v-html="item.description"
            ></div>
          </q-card-section>

        </q-card-section>
        <q-separator class="q-my-md"></q-separator>
        <q-card-actions
          horizontal
          align="left"
        >
          <q-chip
            color="primary"
            text-color="white"
            icon="event"
          >
            {{item.formated_date}}
          </q-chip>

          <q-chip>
            <q-avatar
              color="petecavermelho"
              text-color="white"
            >{{item.qt_access}}</q-avatar>
            Acessos
          </q-chip>

          <router-link
            :to="`/recursos-educacionais/listar?tipos=${item.tipo.id}`"
            class="text-dark"
            target="_blank"
            style="text-decoration: none;"
          >
            <q-chip
              color="petecavermelho"
              text-color="white"
              clickable
            >
              {{item.tipo.name}}
            </q-chip>
          </router-link>

          <router-link
            :to="`/${item.canal.slug}/listar`"
            class="text-dark"
            target="_blank"
            style="text-decoration: none;"
          >
            <q-chip
              clickable
              color="petecavermelho"
              text-color="white"
            >
              {{item.canal.name}}
            </q-chip>
          </router-link>
          <!--q-btn color="pink-9" type="a" target="_blank" :href="item.url_exibir">Visualizar</q-btn-->
        </q-card-actions>
      </q-card>
    </div>
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
  </div>

</template>

<script>
// @ts-nocheck

import { TabComponentesHome, Title } from "../shared";
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
  QSelect,
  QChip,
  QPagination,
  QIcon,
} from "quasar";

export default {
  name: "MenuAvacadoHome",
  components: {
    QIcon,
    TabComponentesHome,
    QList,
    QChip,
    QPagination,
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
    QSelect,
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
        { label: "25 itens", value: 25 },
        { label: "50 itens", value: 50 },
        { label: "100 itens", value: 100 },
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
      total: 0,
      filtros: [],
    };
  },
  beforeDestroy() {
    // alert(this.current);

    sessionStorage.removeItem("pagina");
    sessionStorage.setItem("pagina", this.current);
  },

  computed: {
    ...mapState(["tipos", "licencas", "componentes", "niveis", "conteudos"]),
    getImage() {
      return this.item.image;
    },
  },
  mounted() {
    if (isNaN(this.current)) {
      this.current = 1;
    }

    if (this.total > this.current) {
      this.curret = this.total;
    }

    this.onSearch(this.current);
  },
  updated() {
    // alert(this.current);

    sessionStorage.removeItem("pagina");
    sessionStorage.setItem("pagina", this.current);
  },

  created() {
    this.onSearch();

    this.current = parseInt(sessionStorage.getItem("pagina"));
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
      this.total = data.paginator.total;

      // let pagina = data.paginator.current_page;
      //let pagina_sessao = sessionStorage.getItem("pagina");

      /*
      if (pagina_sessao > 0 || pagina_sessao != null) {
        alert(pagina_sessao);
        sessionStorage.removeItem("pagina");
        sessionStorage.setItem("pagina", pagina_sessao);
        this.current = sessionStorage.getItem("pagina");
      } else {
        this.current = data.paginator.current_page;
      }
      */
      //this.teste = sessionStorage.getItem("pagina");
      //alert(sessionStorage.getItem("pagina"));
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
    irCanal(canal) {
      this.$router.replace(`/${canal}/listar`);
    },

    irTipoConteudo(conteudoId) {
      this.$router.replace(`/recursos-educacionais/listar?tipos=${conteudoId}`);
    },
  },
};
</script>
<style lang="stylus" scoped>
a:visited {
  color: rgb(123, 31, 162) !important; /* * purple-8 na collor pallete do quasar */
}
</style>