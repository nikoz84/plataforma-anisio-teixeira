<template>
    <article class="row">
        <Player></Player>
        <q-card class="panel panel-default" v-if="this.conteudo">
            <q-card-section class="panel-body">
                <div class="text-h6" v-text="this.conteudo.title"></div>
                <div class="text-subtitle2">
                  <small>Usuário(a) publicador: {{this.conteudo.user.name}} </small>
                </div>
                <div class="break-word" v-html="this.conteudo.description"></div>
                
                <span class="label label-default" v-bind:style="backgroundColor"> Fonte: </span>
                    <i class="i-list break-word">{{ this.conteudo.source }}</i>
                
                <span class="label label-default" v-bind:style="backgroundColor"> Autores: </span>
                <i class="i-list break-word" v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i>
                
                <span class="label label-default" v-bind:style="backgroundColor"> Componentes: </span>
                <i class="i-list break-word"
                    v-for="(componente) in this.conteudo.componentes"
                    v-bind:key="componente.id"
                    v-text="componente.name"
                    ></i>
                
                <span class="label label-default" v-bind:style="backgroundColor"> Licença: </span>
                <i class="i-list break-word" v-if="this.conteudo.license" v-text="this.conteudo.license.name"></i>

            </q-card-section>
            <q-card-section class="panel-footer tag-cloud">
                <div class="text-h6">Tags: </div>
                <router-link :to="`/recursos-educacionais/listar/tag/${tag.id}`">
                  <q-chip color="secondary" 
                        text-color="white"
                        clickable
                        icon="local_offer"
                        v-for="(tag,i) in this.conteudo.tags"
                        :key="`t-${i}`"
                        >
                        {{tag.name}}
                  </q-chip>
                </router-link>
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
  components: { QCard, QCardSection,QSeparator, Player, QChip },
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
    goTo(url){
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