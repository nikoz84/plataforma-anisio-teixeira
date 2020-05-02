<template>
  <div class="row q-mt-md" v-if="conteudo">
    <div class="col-xs-12 col-sm-6">
      <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
      <PlayerActions class="q-mt-xs"></PlayerActions>
      <q-card class="q-mt-sm">
        <q-card-section>
          <Title :title="conteudo.title"></Title>
        </q-card-section>
        <q-card-section>
          <div v-html="conteudo.description"></div> 
        </q-card-section>
      </q-card>
    </div>
    
    
    <div class="col-xs-12 col-sm-5 q-ml-md">
      <ConteudoMetadata></ConteudoMetadata> 
    </div>
  </div>
</template>
<script>
import Player from "../components/Player";
import { mapState } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import Title from "./Title";
import ConteudoMetadata from './ConteudoMetadata';
import PlayerActions from "./PlayerActions";

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
    PlayerActions
  },
  created() {},
  computed: {
    ...mapState(["conteudo"]),
    backgroundColor() {
      let color = this.conteudo.canal.color;
      return `background-color: ${color}`;
    }
  },
  methods: {
    
  }
};
</script>
<style scoped>

</style>