<template>
  <article class="q-ma-md justify-center">
    <header class="row text-center q-pt-xl q-pb-xl">
      <div class="text-h4 text-light" v-text="data.title"></div>
    </header>
    
    <div class="row q-gutter-xl">
      <q-card class="col-xs-12 col-sm-5 col-md-5 col-lg-5" v-for="(item, i) in data.items" :key="i">
        
          <q-img basic :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`" style="height: 250px; width: 100%;">
            <div class="absolute-bottom text-subtitle1 cursor-pointer">
              <router-link tag="div"
                      :to="item.url_exibir" 
                      v-text="title(item.title ? item.title : item.name)"/>
            </div>
          </q-img>
        
      </q-card>
    </div>
  </article>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "CardHome",
  props: ["data"],
  components: { QImg, QCard, QCardSection, QSeparator },
  methods: {
    title(title) {
      let stringLength = title.length;
      return stringLength > 55 ? title.substr(0, 55) + " ..." : title;
    }
  }
};
</script>
<style lang="stylus" scoped>
.q-img__content > div {
  font-weight: bolder;
  background: rgba(23, 2, 99, 0.6);
}
</style>