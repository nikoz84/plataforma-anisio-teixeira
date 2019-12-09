<template>
  <article class="q-ma-md">
      <b class="home-cat-title text-h5 text-grey-10 q-ma-sm q-pa-sm">{{data.title}}</b>
      <div class="row">
        <q-card class="card-home card-padrao col-md-3 q-ma-sm" v-for="(item, i) in data.items.slice(0, limit)" :key="i">
            <router-link tag="div"
                          :to="item.url_exibir" 
                          class="pointer"
                          :title="item.title ? item.title : item.name">
              <img  class="card-img" :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`">
              <q-card-section>
                <div class="text-body1 text-weight-medium text-grey-10" v-text="title(item.title ? item.title : item.name)"></div>
              </q-card-section>
            </router-link>
        </q-card>
        <q-btn @click="showData($event)" align="left" icon="cached" class="btn-mais-home q-mt-md q-mb-xl full-width" label="Carregar mais" />
      </div>
  </article>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator, QBtn } from "quasar";

export default {
  name: "CardHome",
  props: ["data"],
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
    showData(e) {
      this.limit = this.limit + 3;
      let el = e.target;
      el.classList.add("invisible");
    }
  }
};
</script>
<style lang="stylus" scoped>
.pointer {
  cursor: pointer;
}
</style>