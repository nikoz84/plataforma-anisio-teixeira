<template>
  <article class="q-ma-md">
    <header class="row">
      <div class="text-h4 text-light q-pa-md" v-text="data.title">
      </div>
    </header>
    
    <div class="row q-col-gutter-xs" >
      <q-card class="col-xs-12 col-sm-6 col-md-6 col-lg-3" v-for="(item, i) in data.items" :key="i">
        <q-card-section>
          <q-img :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`" style="height: 200px; width: 100%;">
            <div class="absolute-bottom">
              <router-link
                      :to="item.url_exibir" >
                  <a class="link"> {{ item.title ? item.title : item.name }}</a>
              </router-link>
            </div>
          </q-img>
        </q-card-section>
      </q-card>
    </div>
  </article>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator } from "quasar";

export default {
  name: "CardHome",
  props: ["data"],
  components: { QImg, QCard, QCardSection, QSeparator }
};
</script>
<style lang="stylus" scoped>
.link {
  color: #fff;
  font-weight: bolder;
  font-size: 0.9rem;
  text-decoration: none;
}
</style>