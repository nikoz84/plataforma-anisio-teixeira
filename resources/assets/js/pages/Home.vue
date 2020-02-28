<template>
  <section class="q-pa-sm">
    <a class="skip-link" href="#tipo-conteudos">Ir a tipos de conteúdos</a>
    <CardHomeIcon
      id="tipo-conteudos"
      title="Tipos de Conteúdos"
      :items="tipos"
      style="min-height: 85vh;"
    ></CardHomeIcon>
    <a class="skip-link" href="#disciplinas">Ir a disciplinas do ensino medio</a>
    <CardHomeIcon
      id="disciplinas"
      :title="disciplinas.name"
      :items="disciplinas.componentes"
      style="min-height: 85vh;"
    ></CardHomeIcon>
    <a class="skip-link" href="#temas">Ir a temas transversais</a>
    <CardHomeIcon
      id="temas"
      :title="temas.name"
      :items="temas.componentes"
      style="min-height: 45vh;"
    ></CardHomeIcon>
    
    
    <CardHome v-for="(id, index) in ids"
      :key="index"
      :data="id.data" 
      class="load"
      :show="id.show"
      :animation="id.animation"
      v-scroll-fire="getDestaques" 
      :id="id.name"
      style="min-height: 55vh;"></CardHome>
      
    
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import CardHomeIcon from "../components/CardHomeIcon.vue";
import { ClosePopup } from "quasar";

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
    ...mapState(["tipos", "componentes", "niveis"]),
    disciplinas() {
      if (this.niveis.length) {
        let niveis = this.niveis.filter(nivel => {
          if (nivel.id === 5) return nivel;
        });
        return niveis[0];
      }
    },
    temas() {
      if (this.componentes.length) {
        let componentes = this.componentes.filter(componente => {
          if (componente.id === 3) return componente;
        });
        return componentes[0];
      }
    }
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
