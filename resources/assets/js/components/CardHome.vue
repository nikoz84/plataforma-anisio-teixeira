<template>
  <article class="q-ma-md">
    <div>
      <div class="row bg-grey-5 q-pa-lg">
        <b class="text-h5 text-grey-10">{{data.title}}</b>
      </div>
      <div class="row items-start q-gutter-xs">
        <q-card class="col-sm-3 col-md-3" style="max-heigth:300px;" v-for="(item, i) in data.items" :key="i">
          
              <img style="min-width: 100%; height: 150px;" :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`">
          
          <q-card-section class="q-pa-sm">
            <router-link tag="div"
                          :to="item.url_exibir" 
                          class="pointer text-accent-10"
                          :title="item.title ? item.title : item.name">
                <div class="text-h6" v-text="title(item.title ? item.title : item.name)"></div>
            </router-link>
          </q-card-section>
          </q-card>
      </div>
    </div>
  </article>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "CardHome",
  props: ["data"],
  components: {
    QImg,
    QCard,
    QCardSection,
    QSeparator
  },
  methods: {
    title(title) {
      let stringLength = title.length;
      return stringLength > 100 ? title.substr(0, 100) + " ..." : title;
    }
  }
};
</script>
<style lang="stylus" scoped>
.pointer {
  cursor: pointer;
}
</style>