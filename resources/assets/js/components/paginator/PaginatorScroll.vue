<template>
  <div class="" v-if="paginator">
    <q-infinite-scroll @load="onLoad" :offset="150">
      <div class="row justify-center q-gutter-x-md q-gutter-y-md">
        <PaginatorCard
          class="col-xs-10 col-sm-4 col-md-3 col-lg-3 col-xl-2"
          v-for="(item, i) in infiniteSrollData"
          :key="i"
          v-bind:item="item"
        ></PaginatorCard>
      </div>
      <template v-slot:loading>
        <div class="row justify-center q-my-xl">
          <q-spinner-dots color="accent" size="100px" />
        </div>
      </template>
    </q-infinite-scroll>

    <q-card class="q-mt-xl" v-if="infiniteSrollData.length == 0">
      <q-banner dense class="bg-secondary text-white">
        <p>Sua pesquisa não encontrou nenhum documento correspondente.</p>
        <p>Sugestões:</p>
          <ul>
            <li>Certifique-se de que todas as palavras estejam escritas corretamente.</li>
            <li>Tente palavras-chave diferentes.</li>
            <li>Tente palavras-chave mais genéricas.</li>
            <li>Tente usar menos palavras-chave.</li>
          </ul>
        <p>Se você precisar de algum conteúdo específico por favor envie sua suagerencia</p>
        <template v-slot:action>
          <q-btn flat color="white" to="/recursos-educacionais/listar" label="Voltar" />
          <q-btn flat color="white" to="/usuario/contato/sugerencia" label="Sugerir Conteúdo" />
        </template>
      </q-banner>
    </q-card>
  </div>
</template>
<script>
import { QInfiniteScroll, QSpinnerDots, QCard, QBanner } from "quasar";
import { mapState, mapMutations } from "vuex";
import PaginatorCard from "./PaginatorCard.vue";

export default {
  name: "PaginatorDefault",
  data() {
    return {
      infiniteSrollData: []
    };
  },
  components: { QInfiniteScroll, QSpinnerDots, PaginatorCard, QCard },
  mounted() {
    this.infiniteSrollData = this.infiniteSrollData.concat(this.paginator.data);
  },
  computed: {
    ...mapState(["paginator"])
  },
  methods: {
    ...mapMutations(["SET_PAGINATOR"]),
    async onLoad(index, done) {
      if (this.paginator.next_page_url && this.paginator.data.length > 0) {
        let params = this.queryStringToObject(this.paginator.next_page_url);
        
        let resp = await axios.get(this.paginator.next_page_url);

        this.SET_PAGINATOR(resp.data.paginator);
        this.infiniteSrollData = this.infiniteSrollData.concat(
          this.paginator.data
        );
        done();
        //console.log(this.infiniteSrollData)
      } else {
        done(true);
      }
    },
    queryStringToObject(str) {
      let url = new URL(window.location.origin + str);
      let queryString = url.searchParams.toString();

      let params = queryString
        .replace(/(^\?)/, "")
        .split("&")
        .map(
          function(n) {
            return (n = n.split("=")), (this[n[0]] = n[1]), this;
          }.bind({})
        )[0];

      return params;
    }
  }
};
</script>
<style lang="sass" scoped></style>
