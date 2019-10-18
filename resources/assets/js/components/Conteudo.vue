<template>
    <article class="q-pa-md row">
        <Player class="col-md-6" :arquivos="conteudo.arquivos" :tipo="conteudo.tipo"></Player>
        <q-card class="col-md-6" v-if="conteudo">
            <q-card-section class="">
              <div class="text-h5 q-mb-lg" :style="`color:${conteudo.canal.color};`" v-text="conteudo.title"></div>
              <q-separator class="q-mb-lg" inset />
              <small>
                <b>Usuário(a) publicador(ora):</b> {{ conteudo.user.name }}
              </small> <br>
              <small>
                <b>Acessos:</b> {{ conteudo.qt_access }}
              </small> - 
              <small>
                <b>Downloads:</b> {{ conteudo.qt_downloads }}
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
            <q-card-section>
                <div class="text-h6">Tags: </div>
                <q-chip color="ligth" 
                      icon="local_offer"
                      v-for="(tag, i) in conteudo.tags"
                      :key="i"
                      :label="tag.name"
                      clickable
                      @click="onClick(`/recursos-educacionais/listar/tag/${tag.id}`)"
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