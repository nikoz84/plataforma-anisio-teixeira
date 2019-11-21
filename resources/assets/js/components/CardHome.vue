<template>
  <article class="q-ma-md">
    <q-list>
      <q-item-label class="bg-grey-5" header style="margin-top:60px;">
        <b class="text-h5 text-grey-10">{{data.title}}</b>
      </q-item-label>
      <q-item v-for="(item, i) in data.items" :key="i" clickable class="q-pl-lg">
        <q-item-section top thumbnail class="q-ml-none">
            <img style="min-width: 168px; height: 94px;" :src="item.image" :placeholder-src="`/img/fundo-padrao.svg`">
        </q-item-section>
        <q-item-section>
          
          <router-link tag="div"
                        :to="item.url_exibir" 
                        class="pointer text-blue-10"
                        :title="item.title ? item.title : item.name">
              <q-item-label v-text="title(item.title ? item.title : item.name)"></q-item-label>
          </router-link>
        </q-item-section>
      </q-item>
    </q-list>
  </article>
</template>
<script>
import {
  QImg,
  QCard,
  QCardSection,
  QSeparator,
  QList,
  QItem,
  QItemSection,
  QItemLabel
} from "quasar";

export default {
  name: "CardHome",
  props: ["data"],
  components: {
    QImg,
    QCard,
    QCardSection,
    QSeparator,
    QList,
    QItem,
    QItemSection,
    QItemLabel
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