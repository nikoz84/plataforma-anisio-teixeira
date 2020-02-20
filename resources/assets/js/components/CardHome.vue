<template>
  <section class="q-my-xl">
    <transition appear :enter-active-class="`animated ${animation}`">
      <h1
        v-if="show"
        class="text-h5 title-page text-center q-py-lg text-primary"
        :id="data.slug"
        v-text="data.title"
      ></h1>
    </transition>
    <div class="row justify-center q-gutter-sm">
      <q-card
        flat
        bordered
        class="col-sm-3"
        v-for="(item, i) in data.items"
        :key="i"
      >
        <q-img
          :src="item.image"
          placeholder-src="/img/fundo-padrao.svg"
          loading="lazy"
          aria-label="imagen de destaque"
          alt="imagen de destaque"
        />
        <q-card-section>
          <q-btn
            aria-label="visualizar recurso"
            :to="item.url_exibir"
            :title="item.title ? item.title : item.name"
            class="text-body1 text-weight-medium text-blue-10"
            v-text="title(item.title ? item.title : item.name)"
          >
          </q-btn>
        </q-card-section>
      </q-card>
    </div>
  </section>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator, QBtn } from "quasar";

export default {
  name: "CardHome",
  props: ["data", "animation", "show"],
  components: {
    QImg,
    QCard,
    QCardSection,
    QSeparator,
    QBtn
  },
  methods: {
    title(title) {
      let stringLength = title.length;
      return stringLength > 70 ? title.substr(0, 70) + " ..." : title;
    }
  }
};
</script>
<style lang="stylus" scoped>
.border-left {
}
</style>
