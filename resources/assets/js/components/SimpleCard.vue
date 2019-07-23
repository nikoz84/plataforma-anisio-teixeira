<template>
       <q-card class="row q-mt-lg" v-bind:id="item.id">
          <q-card-section class="col-4" >
            <q-img alt="imagem destacada"
                  :src="getImage"
                  style="height: 200px; max-width: 300px"
                  placeholder-src="/img/fundo-padrao.svg">
              <div class="absolute-bottom-right text-subtitle2">
                {{ getTipo }}
              </div>
            </q-img>
          </q-card-section>

          <q-card-section class="col-8" >
            <div :style="`border-bottom: 2px solid ${color};`"
                  class="text-h6 card-heading-inner q-pt-md"
                  v-text="title">
            </div>
            <p class="q-pt-lg" v-html="item.excerpt"></p>
            <router-link class="absolute-bottom-right text-subtitle2"
                :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}" 
                  flat>
                <QBtn color="secondary" style="font-weight: 900;">Saiba Mais</QBtn>
            </router-link>
          </q-card-section>
          
      </q-card>
</template>
<script>
import { QCard, QCardSection, QBtn, QImg } from "quasar";

export default {
  name: "SimpleCard",
  props: {
    item: Object
  },
  components: { QCard, QCardSection, QBtn, QImg },
  computed: {
    title() {
      return this.item.name ? this.item.name : this.item.title;
    },
    slug() {
      return this.item.canal ? this.item.canal.slug : this.item.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : "#faf";
    },
    getImage() {
      return this.item.image;
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
    }
  },
  created() {}
};
</script>
<style lang="stylus" scoped>
.card-heading-bottom .card-heading-inner {
  padding-bottom: 6px;
  border-bottom: 2px solid #2c87f0;
  position: relative;
  bottom: -1px;
}

.card-heading-inner {
  display: inline-block;
}
</style>
