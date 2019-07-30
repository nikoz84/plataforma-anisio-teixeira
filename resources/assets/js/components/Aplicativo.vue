<template>
  <article class="q-mt-md">
    <q-card v-if="aplicativo">
      <q-card-section>
        <section class="row">
          <div class="col-xs-12 col-sm-7 col-md-7">
            <div class="text-h3" v-text="aplicativo.name"></div>
            <div class="q-pt-lg q-pr-lg" v-html="aplicativo.description"></div>
            <q-chip class="q-mt-lg" color="ligth" :label="`${aplicativo.options.qt_access} acessos`"></q-chip>
          </div>
          
          <div class="col-xs-12 col-sm-4 col-md-4">
            <q-img :src="aplicativo.image"
                    :placeholder-src="`/img/fundo-padrao.svg`" 
                  style="height: 250px; width: 100%;"
                  v-bind:style="`border-color:${aplicativo.canal.color};margin: 0 auto;`"
                  alt="Imagem de destaque">
                  <div class="absolute-bottom text-subtitle1 text-center q-pa-xs">
                     <q-btn class=""
                      v-bind:href="aplicativo.url"
                      target="_blank"
                      flat>
                      Ir ao site
                     </q-btn>
                  </div>
              </q-img>
          </div>
        </section>
      </q-card-section>
      <q-card-section>
        <div class="text-h6">Tags: </div>
        <q-chip color="ligth" 
              icon="local_offer"
              v-for="(tag, i) in aplicativo.tags"
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
import { mapState } from "vuex";
import { QImg, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "Aplicativo",
  components: { QImg, QCard, QCardSection, QSeparator },
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
    },
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
