<template>
  <div class="row justify-start" v-if="conteudo">
    
    <div class="col-md-8 col-sm-12" >
      <q-card>
        <q-card-section class="player col-12">
          <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
        </q-card-section>
        <q-card-section class="acoes col-12 q-mx-md">
          <PlayerActions></PlayerActions>
        </q-card-section>
        <q-card-section class="descritivo col-12 q-mx-md q-mb-sm">
              <Title :title="conteudo.title"></Title>
              <div class="q-mt-lg  conteudo-descricao" v-html="conteudo.description"></div> 
        </q-card-section>
        <q-card-section class="ficha-tecnica col-12 q-mt-lg">
          <q-expansion-item
            dense
            :default-opened="isMobile"
            header-class="bg-cinza text-black"
            label="Ficha Técnica">
              <ConteudoMetadata></ConteudoMetadata> 
          </q-expansion-item>
        </q-card-section>
      </q-card>
    </div>

    <div class="col-md-4 col-sm-12">
      <q-card class="q-mt-sm q-ml-sm q-pt-xs">
        <strong class="q-pa-sm" >Conteúdo Relacionado</strong>
        <ConteudoRelated></ConteudoRelated>
      </q-card>
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import { Player, PlayerActions } from "@components/player";
import { Title } from "@components/shared";
import ConteudoMetadata from "@components/exibir/ConteudoMetadata";
import ConteudoRelated from "@components/exibir/ConteudoRelated";


export default {
  name: "Conteudo",
  directives: { Ripple },
  components: {
    QCard,
    QCardSection,
    QSeparator,
    Player,
    QChip,
    Title,
    ConteudoMetadata,
    PlayerActions,
    ConteudoRelated
  },
  computed: {
    ...mapState(["conteudo"]),
    backgroundColor() {
      let color = this.conteudo.canal.color;
      return `background-color: ${color}`;
    },
    isMobile() {
      let is_mobile = this.$q.screen.gt.xs || this.$q.screen.gt.sm;
      return  is_mobile;
    }
  },
  methods: {
    ...mapActions(['fetchConteudo'])
  },
  watch: {
    $route(to, from) {
      if (to.fullPath != from.fullPath) {
        this.fetchConteudo(this.$route.params);
      }
    }
  }
};
</script>
<style scoped>

.conteudo-descricao::before{
  content:"Descrição: "
}

.conteudo-descricao{
  font-size: 1rem;
  line-height: 1.3rem;
}

</style>