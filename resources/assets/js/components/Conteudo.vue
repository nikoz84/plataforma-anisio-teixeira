<template>
    <article class="row q-mt-sm">
        <q-card v-if="conteudo">
            <Player class="row" :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
            
            <q-card-section class="">
              <div class="text-h4">{{conteudo.title}}</div>
              <q-separator></q-separator>
              <small>
                Acessos: 
                <q-badge color="secondary">{{conteudo.qt_access}}</q-badge>
              </small>
              <small>
                Downloads: 
                <q-badge color="secondary">{{conteudo.qt_downloads}}</q-badge>
              </small>
              <small>
                Publicador(a): 
                <q-badge color="secondary">{{conteudo.user.name}}</q-badge>
              </small>
              <small>
                Publicado em: 
                <q-badge color="secondary">{{conteudo.formated_date}}</q-badge>
              </small>
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
                <div class="text-h6">Tags: </div>
                <q-chip color="ligth" 
                      icon="local_offer"
                      v-for="(tag, i) in conteudo.tags"
                      :key="i"
                      :label="tag.name"
                      clickable
                      @click="onClick(`/recursos-educacionais/listar?tag=${tag.id}`)"
                      >
                      
                </q-chip>
            </q-card-section>
        </q-card>
    </article>
</template>
<script>
import Player from "../components/Player.vue";
import { mapState } from "vuex";
import { QCard, QCardSection, QSeparator, QChip } from "quasar";

export default {
  name: "Conteudo",
  components: { QCard, QCardSection, QSeparator, Player, QChip },
  created() {},
  computed: {
    ...mapState(["conteudo"]),
    splitAuthors() {
      let replace = this.conteudo.authors.replace(",", ";");
      return replace.split(";");
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