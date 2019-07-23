<template>
    <article class="row">
        <Player></Player>
        <div class="panel panel-default" v-if="this.conteudo">
            <div class="panel-body">
                <h2 v-text="this.conteudo.title"></h2>
                <small></small>
                <div class="break-word" v-html="this.conteudo.description"></div>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Fonte: </span>
                    <i class="i-list break-word">{{ this.conteudo.source }}</i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Autores: </span>
                <i class="i-list break-word" v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Componentes: </span>
                <i class="i-list break-word"
                    v-for="(componente) in this.conteudo.componentes"
                    v-bind:key="componente.id"
                    v-text="componente.name"
                    ></i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Licença: </span>
                <i class="i-list break-word" v-if="this.conteudo.license" v-text="this.conteudo.license.name"></i>
            </div>
            <div class="panel-footer tag-cloud">
                <h5>Tags: </h5>
                <q-chip outline color="primary" 
                      text-color="white"
                      clickable
                      v-for="tag in this.conteudo.tags"
                      :key="tag.id"
                      >
                      <router-link :to="`/recursos-educacionais/listar/tag/${tag.id}`">
                        <a :style="'text-decoration: none;'">{{tag.name}}</a>
                      </router-link>
                </q-chip>
                
            </div>
        </div>
    </article>
</template>
<script>
import Player from "../components/Player.vue";
import { mapState } from "vuex";
import { QChip } from "quasar";

export default {
  name: "Conteudo",
  components: { Player, QChip },
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