<template>
    <article class="panel panel-default" v-if="this.aplicativo">
        <div class="panel-body">
            <h2 v-text="aplicativo.name"></h2>
            <div class="row">
                <div class="col-sm-8 break-word" v-html="aplicativo.description"></div>
                <figure class="col-sm-4">
                    <img v-lazy="aplicativo.image"
                        class="img-responsive thumbnail"
                        v-bind:style="`border-color:${aplicativo.canal.color};margin: 0 auto;`"
                        alt="Imagem de destaque">
                    <a class="btn btn-success btn-block"
                        v-bind:href="aplicativo.url"
                        v-bind:style="`background-color: ${aplicativo.canal.color};margin-top:15px;`"
                        target="_blank">
                        Ir ao site
                    </a>
                </figure>
            </div>
            <hr class="line">
            <span class="label label-default" v-bind:style="'background-color:' + aplicativo.canal.color"> Acessos: </span>
            <i class="i-list break-word" v-text="aplicativo.options.qt_access"></i>
        </div>
        <div class="panel-footer tag-cloud">
            <h5> Tags: </h5>
            <a :style="`color:${aplicativo.canal.color};`" 
              href=""
                v-for="tag in aplicativo.tags"
                v-bind:key="tag.id"
                v-text="tag.name">
            </a>
        </div>
    </article>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "Aplicativo",
  components: {},
  computed: {
    ...mapState(["aplicativo"]),
    splitAuthors() {
      let replace = this.aplicativo.authors.replace(",", ";");
      return replace.split(";");
    }
  },
  methods: {
    async deleteAplicativo() {
      let params = {
        token: localStorage.token
      };
      let resp = await axios.delete(
        `/aplicativos/${this.$route.params.id}`,
        params
      );
      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      }
    },
    updateAplicativo() {
      this.$router.push({
        name: "EditarAplicativo",
        params: {
          slug: this.$route.params.slug,
          id: this.$route.params.id,
          update: true
        }
      });
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
