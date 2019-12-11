<template>
  <article class="q-ma-md">
      <div class="text-h5 text-grey-10 q-ma-md q-pa-sm title-page">{{data.title}}</div>
      <div class="row q-gutter-md">
        <q-card flat bordered class="col-sm-3" v-for="(item, i) in data.items.slice(0, limit)" :key="i">
            <img :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`">
            <router-link tag="div"
                          :to="item.url_exibir" 
                          class="cursor-pointer"
                          :title="item.title ? item.title : item.name">
              <q-card-section>
                <div class="text-body1 text-weight-medium text-blue-10" v-text="title(item.title ? item.title : item.name)"></div>
              </q-card-section>
            </router-link>
        </q-card>
      </div>
      <div class="row no-wrap justify-center q-ma-xl" >
        <div class="col-sm-4">
          <q-btn flat 
                no-caps 
                no-wrap
                :id="`${index}`"
                @click="showData" 
                align="left" 
                icon="cached" 
                class="full-width border-left" 
                label="Carregar mais" />
        </div>
      </div>
  </article>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator, QBtn } from "quasar";

export default {
  name: "CardHome",
  props: ["data", "index"],
  components: {
    QImg,
    QCard,
    QCardSection,
    QSeparator,
    QBtn
  },
  data() {
    return {
      limit: 3,
      show: true
    };
  },
  methods: {
    title(title) {
      let stringLength = title.length;
      return stringLength > 70 ? title.substr(0, 70) + " ..." : title;
    },
    showData() {
      this.limit = this.limit + 3;
      let el = document.getElementById();

      //hide.classList.add("invisible");
    }
  }
};
</script>
<style lang="stylus" scoped>
.border-left {
}
</style>