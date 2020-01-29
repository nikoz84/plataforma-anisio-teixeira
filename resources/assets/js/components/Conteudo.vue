<template>
    <article class="row q-mt-sm">
        <q-card v-if="conteudo">
            <Player class="row" :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
            
            <q-card-section class="">
              <Title :title="conteudo.title"></Title>
              
              <small v-if="conteudo.user">
                Publicador(a): 
                <q-badge class="cursor-pointer"
                        :bg-color="conteudo.canal.color"
                        @click="onClick(`/recursos-educacionais/listar?publicador=${conteudo.user.id}`)">
                  {{conteudo.user.name}}
                </q-badge>
                <q-tooltip>
                        Outros conteúdos deste publicador
                </q-tooltip>
              </small>
              <q-space></q-space>
              <small>
                Publicado em: 
                <q-badge color="secondary">{{conteudo.formated_date}}</q-badge>
              </small>
            </q-card-section>
            <q-card-section>
              <div v-html="conteudo.description"></div> 
            </q-card-section>
            <q-card-section>
              <q-chip color="ligth" label="Fonte:"> </q-chip>
                      <i class="i-list break-word">{{ conteudo.source }}</i>
              <q-separator class="q-mb-lg" inset/>
              <q-chip label="Autores:" color="ligth"></q-chip>
              <i class="i-list break-word" v-for="(author,i) in splitAuthors" v-bind:key="`a-${i}`" v-text="author"></i>
              <q-separator class="q-mb-lg" inset/>
              <q-chip label="Licença:" color="ligth"></q-chip>
              <i class="i-list break-word" v-if="conteudo.license" v-text="conteudo.license.name"></i>
              <q-separator class="q-mb-lg" inset/>
              <q-chip label="Componentes:" color="ligth"></q-chip>
              <i class="i-list break-word"
                  v-for="(componente) in conteudo.componentes"
                  :key="`c-${componente.id}`"
                  v-text="componente.name"
                  ></i>
            </q-card-section>
            <q-separator class="q-mb-lg" inset/>
            <q-card-section>
              <TagList :items="conteudo.tags" title="Tags" slug="tag"></TagList>
            </q-card-section>
        </q-card>
    </article>
</template>
<script>
import Player from "../components/Player.vue";
import { mapState } from "vuex";
import { QCard, QCardSection, QSeparator, QChip, Ripple } from "quasar";
import Title from "./Title.vue";
import TagList from "./TagList.vue";

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
    TagList
  },
  created() {},
  computed: {
    ...mapState(["conteudo"]),
    splitAuthors() {
      if (this.conteudo.authors) {
        let replace = this.conteudo.authors.replace(",", ";");
        return replace.split(";");
      }
    },
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
i::before {
  content: " » ";
  padding-right: 5px;
  padding-left: 7px;
}
</style>