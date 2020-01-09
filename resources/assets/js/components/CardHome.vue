<template>
  <article class="q-my-xl">
    <q-separator class="bg-white"></q-separator>
    <div class="text-h5 title-page text-center q-py-lg">
      {{ data.title }}
    </div>
    <div class="row justify-center q-gutter-sm q-py-xl">
      <q-card
        flat
        bordered
        class="col-sm-3"
        v-for="(item, i) in data.items"
        :key="i"
      >
        <q-img :src="item.image" placeholder-src="/img/fundo-padrao.svg" aria-label="imagen de destaque" alt="imagen de destaque"/>
        <router-link
          tag="div"
          aria-label="visualizar recurso"
          :to="item.url_exibir"
          class="cursor-pointer"
          :title="item.title ? item.title : item.name"
        >
          <q-card-section>
            <div
              class="text-body1 text-weight-medium text-blue-10"
              v-text="title(item.title ? item.title : item.name)"
            ></div>
          </q-card-section>
        </router-link>
      </q-card>
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
