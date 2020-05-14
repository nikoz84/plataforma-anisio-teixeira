<template>
  <div class="row justify-start" v-if="conteudo">
    
    <div class="col-9" style="max-width:1200px">
      <q-card>
        <div class="player col-12 q-mt-sm">
          <Player :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
        </div>
        <div class="acoes col-12 q-mx-md">
          <PlayerActions></PlayerActions>
        </div>
        <div class="descritivo col-12 q-mx-md q-mb-sm">
              <Title :title="conteudo.title"></Title>
              <div class="q-mt-lg  conteudo-descricao" v-html="conteudo.description"></div> 
        </div>
        <div class="ficha-tecnica col-12 q-mx-0">
          <q-expansion-item
            v-model="expanded"
            dense
            switch-toggle-side
            header-class="bg-cinza text-black"
            label="Ver ficha técnica">
              <ConteudoMetadata></ConteudoMetadata> 
          </q-expansion-item>
        </div>
      </q-card>
    </div>

    <div class="col-3">
      <q-card class="q-mt-sm q-ml-sm">
        <q-list bordered>
          <q-item clickable v-ripple>
            <q-item-section thumbnail>
              <img src="https://cdn.quasar.dev/img/mountains.jpg">
            </q-item-section>
            <q-item-section>List item</q-item-section>
          </q-item>
        </q-list>
      </q-card>
    </div>

    
  </div>
</template>

<!-- código antigo

<template>
  <div class="row justify-center q-mt-md q-gutter-sm" v-if="conteudo">
    <div class="col-xs-11 col-sm-6">
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
    <div class="col-xs-11 col-sm-5">
      <ConteudoMetadata></ConteudoMetadata> 
    </div>
  </div>
</template>

-->

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

.conteudo-descricao::before{
  content:"Descrição: "
}

.conteudo-descricao{
  font-size: 1rem;
  line-height: 1.3rem;
}

@media (max-width: 599px){
  .player{
  order: 1;
}

.descritivo{
  order: 3;
}

.acoes{
  order: 2;
}

.ficha-tecnica{
  order: 4;
}
}

</style>