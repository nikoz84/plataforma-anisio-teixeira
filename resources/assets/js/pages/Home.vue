<template>
  <section class="q-pa-sm">
    <a class="skip-link" href="#tipo-conteudos">ir a tipo de conteúdos</a>
    <CardHomeIcon
      id="tipo-conteudos"
      title="Tipos de Conteúdos"
      :items="tipos"
      source="tipo-conteudo"
      style="padding-bottom: 20vh;"
    ></CardHomeIcon>
    <a class="skip-link" href="#disciplinas">disciplinas</a>
    <CardHomeIcon
      id="disciplinas"
      title="Disciplinas"
      :items="disciplinas.components"
      source="emitec"
      style="padding-bottom: 15vh;"
    ></CardHomeIcon>
    <div class="q-my-lg load" v-scroll-fire="getDestaques"></div>
    <CardHome
      :data="data"
      v-for="(data, i) in destaques"
      :key="`i-${i}`"
    />
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import CardHomeIcon from "../components/CardHomeIcon.vue";

import {
  QParallax,
  ScrollFire,
  QBanner,
  QCard,
  QCardSection,
  QCardActions,
  QBtn,
  QAvatar
} from "quasar";

export default {
  name: "Home",
  directives: {
    ScrollFire
  },
  components: {
    QParallax,
    CardHome,
    QBanner,
    QCard,
    QCardSection,
    QCardActions,
    QBtn,
    QAvatar,
    CardHomeIcon
  },

  data() {
    return {
      destaques: []
    };
  },
  computed: {
    ...mapState(["disciplinas", "tipos"])
  },
  methods: {
    async getDestaques(el) {
      if (el.classList.contains("load")) {
        let resp = await axios.get("/destaques");
        if (resp.status == 200 && resp.data.success) {
          this.destaques = resp.data.metadata;
        }
        el.classList.remove("load");
      }
    }
  }
};
</script>
<style lang="scss" scoped></style>
