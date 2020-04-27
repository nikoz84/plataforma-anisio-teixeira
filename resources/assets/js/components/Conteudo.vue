<template>
  <div class="row justify-start q-gutter-sm q-mt-md" v-if="conteudo">
    <Player class="col-sm-12 col-md-6" :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
    <q-card class="col-sm-12 col-md-5">
            <q-card-section>
              <Title :title="conteudo.title"></Title>
              
              <small v-if="conteudo.user">
                Publicador(a): 
                <q-badge class="cursor-pointer"
                        color="blue-grey-6"
                        @click="onClick(`/recursos-educacionais/listar?publicador=${conteudo.user.id}`)">
                  {{conteudo.user.name}}
                  <q-icon name="link" size="14px" class="q-ml-xs"/>
                </q-badge>
                
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                        Outros conteúdos deste publicador
                </q-tooltip>
              </small>
              <q-space></q-space>
              <small>
                Publicado em: 
                <q-badge color="bg-grey">{{conteudo.formated_date}}</q-badge>
              </small>
            </q-card-section>
            <q-card-section>
              <div v-html="conteudo.description"></div> 
            </q-card-section>
            
    </q-card>
  </div>
</template>
<script>
import Player from "../components/Player.vue";
import { mapState } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import Title from "./Title.vue";


export default {
  name: "Conteudo",
  directives: { Ripple },
  components: {
    QCard,
    QCardSection,
    QSeparator,
    Player,
    QChip,
    Title
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
    onClick(url) {
      this.$router.push(url);
    }
  }
};
</script>
<style scoped>

</style>