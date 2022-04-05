<template>
  <section class="q-my-xl ">
    <div class="text-h5 title-page text-primary separatriz q-pb-md">
      {{ title }}
    </div>
    <div class="separatriz-6"></div>
    <div class="row justify-center q-py-lg q-gutter-lg">
      <PaginatorCard
        v-for="(item, i) in items"
        :key="i"
        class="col-xs-10 col-md-3"
        :item="item"
      >
      </PaginatorCard>
    </div>
  </section>
</template>
<script>
// @ts-nocheck

import { QImg, QSeparator, QBtn } from "quasar";
import { PaginatorCard } from "@components/paginator";

export default {
  name: "CardHome",
  components: {
    QImg,
    PaginatorCard,
    QSeparator,
    QBtn,
  },
  data() {
    return {
      items: [],
      title: null,
    };
  },
  created() {
    this.getDestaques();
  },
  methods: {
    async getDestaques() {
      const { data } = await axios.get(
        "/conteudos/destaques/conteudos-recentes"
      );
      //console.log(data)e
      if (data) {
        this.items = data.metadata.items;
        this.title = data.metadata.title;
      }
    },
  },
};
</script>

