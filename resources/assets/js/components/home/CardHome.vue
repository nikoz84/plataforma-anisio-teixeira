<template>
  <section class="q-my-xl">
    <div class="row justify-start q-gutter-sm">
        <q-card
          flat
          bordered
          class="col-xs-11 col-sm-10 col-md-3 col-lg-2"
          v-for="(item, i) in items"
          :key="i"
        >
      </q-card>
    </div>
  </section>
</template>
<script>
import { QImg, QCard, QCardSection, QSeparator, QBtn } from "quasar";

export default {
  name: "CardHome",
  props: ["items"],
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

