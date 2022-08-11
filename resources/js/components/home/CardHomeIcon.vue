<template>
  <section class="q-py-xl q-mb-xl">
    <div
      class="row justify-center q-py-lg q-gutter-lg full-width bg-fix q-pb-xl"
      :style="background"
    >
      <q-btn
        class="q-py-xl bg-grey-3 card-icon"
        stack
        v-for="(item, i) in items"
        :key="`item-${i}`"
        :to="item.search_url"
        :aria-label="item.name"
        style="width: 200px; height: 200px;"
      >
        <q-avatar left square>
          <img lazyload :src="item.icon" alt="icone" />
        </q-avatar>
        <div class="q-pt-md text-h6" style="line-height:16px">
          {{ item.name }}
        </div>
      </q-btn>
    </div>
  </section>
</template>
<script>
import { QBtn, QAvatar } from "quasar";
export default {
  name: "CardHomeIcon",
  components: { QBtn, QAvatar },
  props: ["title", "items", "bgSessao"],
  data() {
    return {
      rounded: false,
    };
  },
  computed: {
    background: function() {
      return `background: url('${this.bgSessao}')`;
    },
  },
};
</script>

<!--  STYLE CRIADO PARA A SEPARATRIZ DOS TÍTULOS -->

<style lang="stylus">
.separatriz {
  border: 1px solid;
  border-color: transparent;
  border-bottom-color: #c9c9c9;
  font-family: 'Lato', sans-serif, cursive;
}

.separatriz-6 {
  content: ' ';
  width: 80px;
  height: 10px;
  margin-top: -6px;
}

.card-icon{
  opacity : 0.95;
}

.bg-fix{
  background-size: cover !important;
  background-repeat: no-repeat !important;
  background-color: #2072a230 !important;
  background-blend-mode: luminosity;
  background-position: center !important;
}
</style>
