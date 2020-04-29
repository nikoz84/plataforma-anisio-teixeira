<template>
  <div class="row q-mt-md" v-if="conteudo">
    <div class="col-sm-12 col-md-6">
      <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
      <ConteudoMetadata></ConteudoMetadata>
    </div>
    
    <q-card class="col-sm-12 col-md-6">
      <q-card-section>
        <Title :title="conteudo.title"></Title>
      </q-card-section>
      <q-card-section>
        <div v-html="conteudo.description"></div> 
      </q-card-section>
    </q-card>
  </div>
</template>
<script>
import Player from "../components/Player";
import { mapState } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import Title from "./Title";
import ConteudoMetadata from './ConteudoMetadata';

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
    ConteudoMetadata
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