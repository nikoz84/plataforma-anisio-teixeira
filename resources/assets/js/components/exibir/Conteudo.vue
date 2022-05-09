<template>
  <div class="row justify-start" v-if="conteudo">
    
    <div class="col-md-8 col-sm-12" >
      <q-card>
        <q-card-section class="player">
          <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
          <PlayerActions class="q-mt-sm"></PlayerActions>
        </q-card-section>
        <q-card-section class="ficha-tecnica col-sm-12 q-mt-lg">
          <q-expansion-item
            dense
            :default-opened="isLargestScreen"
            header-class="bg-cinza text-black"
            label="Ficha Técnica">
              <ConteudoMetadata></ConteudoMetadata> 
          </q-expansion-item>
        </q-card-section>
      </q-card>
    </div>

    <div class="col-md-4 col-sm-12" :class="{'q-mt-sm': !isLargestScreen }">
      <q-card class="" :class="{'q-ml-sm': isLargestScreen }">
        <q-card-section>
          <strong class="q-pa-sm" >Conteúdo(s) Relacionado(s)</strong>
        </q-card-section>
        <q-card-section>
          <ConteudoRelated></ConteudoRelated>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>
<script>// @ts-nocheck

import { mapState, mapActions } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import { Player, PlayerActions } from "@components/player";

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
    isLargestScreen() {
      let isLargest = this.$q.screen.gt.xs || this.$q.screen.gt.sm;
      return  isLargest;
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

.conteudo-descricao{
  font-size: 1rem;
  line-height: 1.3rem;
}

</style>