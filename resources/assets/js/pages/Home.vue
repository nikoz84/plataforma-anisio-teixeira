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
    
    <CardHome v-for="(id, index) in ids"
      :key="index"
      :data="id.data" 
      class="load"
      :show="id.show"
      :animation="id.animation"
      v-scroll-fire="getDestaques" 
      :id="id.name"
      style="padding-bottom: 15vh;"></CardHome>
      
    
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
      ids: [
        {
          name: "conteudos-recentes",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "conteudos-destacados",
          animation: "slideInRight",
          show: false,
          data: []
        },
        {
          name: "conteudos-mais-baixados",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "conteudos-mais-acessados",
          animation: "bounceInRight",
          show: false,
          data: []
        },
        {
          name: "aplicativos-recentes",
          animation: "bounceInLeft",
          show: false,
          data: []
        },
        {
          name: "aplicativos-destacados",
          animation: "bounceInRight",
          show: false,
          data: []
        }
      ]
    };
  },
  computed: {
    ...mapState(["disciplinas", "tipos"])
  },
  methods: {
    async getDestaques(el) {
      let slug = "/destaques/" + el.id;

      if (el.classList.contains("load")) {
        this.$q.loading.show();
        let resp = await axios.get(slug);
        if (resp.status == 200 && resp.data.success) {
          this.pushData(el.id, resp.data.metadata, el);
          this.$q.loading.hide();
        }
        el.classList.remove("load");
      }
    },
    pushData(find, data, el) {
      const element = this.ids.find(item => item.name === find);
      element.show = true;
      el.classList.add(element.animation);
      element.data = data;
    }
  }
};
</script>
<style lang="scss" scoped></style>
