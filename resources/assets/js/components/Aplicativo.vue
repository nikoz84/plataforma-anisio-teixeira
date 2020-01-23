<template>
  <article class="q-mt-md" v-if="aplicativo">
    <q-card>
      <q-card-section>
        <section class="row">
          <div class="col-xs-12 col-sm-7 col-md-7">
            <div class="text-h3 text-center">{{aplicativo.name}}</div>
            <section class="q-my-xl text-center">
              <q-separator class="q-mb-lg" />
              <small>
                Publicador(a): 
                <q-badge color="secondary">{{aplicativo.user.name}}</q-badge>
              </small> 
              <small>
                  Publicado em: 
                  <q-badge color="secondary">{{aplicativo.formated_date}}</q-badge>
                </small> 
              <small v-if="aplicativo.options">
                Acessos: 
                <q-badge color="secondary">{{aplicativo.options.qt_access}}</q-badge>
              </small>
            </section>
            <div class="q-pt-lg q-pr-lg" v-html="aplicativo.description"></div>
          </div>
          <q-separator class="q-mb-lg" />
          <div class="col-xs-12 col-sm-5 col-md-5">
            <figure class="row">
              <q-img :src="aplicativo.image"
                  v-if="aplicativo.canal"
                  :placeholder-src="`/img/fundo-padrao.svg`" 
                  style="height: 250px; width: 100%;"
                  v-bind:style="`border-color:${aplicativo.canal.color};margin: 0 auto;`"
                  alt="Imagem de destaque">
                  <div class="absolute-bottom text-subtitle1 text-center q-pa-xs bg-secondary">
                     <q-btn 
                      v-bind:href="aplicativo.url"
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
        <div class="text-h6">Tags: </div>
        <q-chip color="ligth" 
              icon="local_offer"
              v-for="(tag, i) in aplicativo.tags"
              :key="i"
              :label="tag.name"
              clickable
              @click="onClick(`/recursos-educacionais/listar?busca=${tag.name}`)"
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
