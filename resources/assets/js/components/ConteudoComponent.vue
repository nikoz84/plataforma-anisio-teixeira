<template>
    <article class="row">
        <PlayerApp />
        <div class="panel panel-default">
            <div class="panel-body">
                <button class="btn btn-info btn-xs" v-on:click="updateConteudo()">Editar</button>
                <button class="btn btn-danger btn-xs" v-on:click="deleteConteudo()">Apagar</button>
                <h2 v-text="conteudo.title"></h2>
                <small></small>
                <div class="break-word" v-html="conteudo.description"></div>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Fonte: </span>
                    <i class="i-list break-word">{{ conteudo.source }}</i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Autores: </span>
                <i class="i-list break-word" v-for="(author,i) in splitAuthors" v-bind:key="i" v-text="author"></i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Componentes: </span>
                <i class="i-list break-word"
                    v-for="(componente) in conteudo.componentes"
                    v-bind:key="componente.id"
                    v-text="componente.name"
                    ></i>
                <hr class="line">
                <span class="label label-default" v-bind:style="backgroundColor"> Licença: </span>
                <i class="i-list break-word" v-text="conteudo.license.name"></i>
            </div>
            <div class="panel-footer">
                <h5>Tags: </h5>
                <a class="btn btn-default tag"
                    v-for="tag in conteudo.tags"
                    v-bind:key="tag.id"
                    v-bind:href="'/recursos-educacionais-abertos/listar/tag/'+ tag.id"
                    v-text="tag.name">
                </a>
            </div>
        </div>
    </article>
</template>
<script>
import PlayerApp from "../components/PlayerComponent.vue";
import client from "../client.js";

export default {
  name: "ConteudoApp",
  components: { PlayerApp },
  props: ["message"],
  computed: {
    splitAuthors() {
      let replace = this.$store.state.conteudo.authors.replace(",", ";");
      return replace.split(";");
    },
    backgroundColor() {
      let color = this.$store.state.conteudo.canal.color;
      return `background-color: ${color}`;
    },
    conteudo() {
      return this.$store.state.conteudo;
    }
  },
  methods: {
    updateConteudo() {
      this.$router.push({
        name: "EditarConteudo",
        params: {
          slug: this.$route.params.slug,
          id: this.$route.params.id,
          update: true
        }
      });
    },
    async deleteConteudo() {
      let params = {
        token: localStorage.token
      };
      let resp = await client.delete(
        `/conteudos/${this.$route.params.id}`,
        params
      );

      //lista os conteúdos
      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      }
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