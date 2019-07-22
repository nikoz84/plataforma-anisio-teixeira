<template>
    <div>
       <q-card v-bind:id="item.id">
          <q-card-section>
            <q-img alt="imagem destacada" 
                  :src="getImage"
                  placeholder-src="/img/fundo-padrao.svg">
              <div class="absolute-bottom-right text-subtitle2">
                {{ getTipo }}
              </div>
            </q-img>
          </q-card-section>

          <q-card-section>
            <div :style="`border-bottom: 2px solid ${color}`" 
                  class="text-h6 card-heading-inner"
                  v-text="title">
            </div>
            <p v-html="item.excerpt"></p>
          </q-card-section>
          <q-card-actions>
            <q-btn :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}" flat>Saiba Mais</q-btn>
          </q-card-actions>
        </q-card>
    </div>
</template>
<script>
import { QCard, QCardSection, QCardActions, QImg } from "quasar";

export default {
  name: "SimpleCard",
  props: {
    item: Object
  },
  components: { QCard, QCardSection, QCardActions, QImg },
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
