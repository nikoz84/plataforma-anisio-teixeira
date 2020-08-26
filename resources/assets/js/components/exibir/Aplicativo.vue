<template>
  <article class="q-mt-md" v-if="aplicativo">
    <q-card>
      <q-card-section>
        <section class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <Title :title="aplicativo.name"></Title>
            <div class="q-pt-lg q-pr-lg" v-html="aplicativo.description"></div>
            <section class="q-mt-lg">
              <strong>Categoria: </strong>
                {{aplicativo.category.name}}
              <q-separator class="q-my-md"></q-separator>
              <strong>Publicador(a): </strong>
                {{aplicativo.user.name}}
                
              <q-separator class="q-my-md"></q-separator>
              <strong>Publicado em: </strong>
                {{aplicativo.formated_date}}
                
              <q-separator class="q-my-md"></q-separator>
              <strong>Acessos: </strong>
                {{aplicativo.options.qt_access}}
                
              <q-separator class="q-my-md"></q-separator>
            </section>
          </div>
          
          <div class="col-xs-12 col-sm-5 col-md-5">
            <figure>
              <q-img :src="aplicativo.image"
                  v-if="aplicativo.canal"
                  :placeholder-src="`/img/fundo-padrao.svg`" 
                  style="height: 250px; width: 100%;"
                  v-bind:style="`border-color:${aplicativo.canal.color};margin: 0 auto;`"
                  alt="Imagem de destaque">
                  <div class="absolute-bottom text-subtitle1 text-center q-pa-xs bg-secondary">
                     <q-btn 
                      :href="aplicativo.url"
                      type="a" 
                      target="_blank"
                      flat>
                      Ir ao site
                     </q-btn>
                  </div>
              </q-img>
            </figure>
          </div>
        </section>
      </q-card-section>
      <q-card-section>
        <TagList :items="aplicativo.tags" title="Tags" slug="busca"></TagList>
      </q-card-section>
    </q-card>
  </article>
</template>
<script>
import { mapState } from "vuex";
import { QImg, QCard, QCardSection, QSeparator } from "quasar";
import { Title, TagList } from "@components/shared";

export default {
  name: "Aplicativo",
  components: { QImg, QCard, QCardSection, QSeparator, Title, TagList },
  computed: {
    ...mapState(["aplicativo"]),
    splitAuthors() {
      let replace = this.aplicativo.authors.replace(",", ";");
      return replace.split(";");
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
