<template>
    <article class="row">
        <PlayerApp />
        <div class="panel panel-default" v-if="this.conteudo">
            <div class="panel-body">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <router-link :to="updateConteudo">
                    <a class="btn btn-default btn-xs">Editar</a>  
                  </router-link> 
                  <router-link :to="deleteConteudo">
                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal">Apagar</a>  
                  </router-link> 
                </div>
                
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
            <div class="panel-footer">
                <h5>Tags: </h5>
                <a class="btn btn-default tag"
                    v-for="tag in this.conteudo.tags"
                    v-bind:key="tag.id"
                    v-bind:href="'/recursos-educacionais-abertos/listar/tag/'+ tag.id"
                    v-text="tag.name">
                </a>
            </div>
        </div>
    </article>
</template>
<script>
import Player from "../components/Player.vue";
import client from "../client.js";
import { mapState } from "vuex";

export default {
  name: "Conteudo",
  components: { Player },
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
    },
    updateConteudo() {
      return `/${this.$route.params.slug}/editar/${this.$route.params.id}`;
    },
    deleteConteudo() {
      console.log();
      return "";
      /*
      //lista os conteúdos
      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      }
      */
    }
  },
  methods: {}
};
</script>
<style scoped>
i::before {
  content: " » ";
  padding-right: 5px;
  padding-left: 7px;
}
</style>