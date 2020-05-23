<template>
  <div class="row justify-start" v-if="conteudo">
    
    <div class="col-md-8 col-sm-12" >
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
        <div class="ficha-tecnica col-12 q-mt-lg">
          <q-expansion-item
            dense
            switch-toggle-side
            header-class="bg-cinza text-black"
            label="Ver ficha técnica">
              <ConteudoMetadata></ConteudoMetadata> 
          </q-expansion-item>
        </div>
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
import { mapState } from "vuex";
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