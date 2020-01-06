<template>
  <section class="row q-pa-sm">
    
	  <div class="row items-center q-gutter-sm load" v-scroll-fire="getDestaques"> 
      <q-card class="col-sm-2" v-for="(disciplina, i) in disciplinas.components" :key="`d-${i}`">
        <q-card-section avatar>
          <q-avatar>
            <img rounded-borders :title="disciplina.name" :src="`/storage/conteudos/conteudos-digitais/imagem-associada/emitec/ico-${disciplina.id}.svg`" >
          </q-avatar>
        </q-card-section>
        <q-card-actions >
          <q-btn class="full-width" :label="disciplina.name" :to="`recursos-educacionais/listar?busca=${disciplina.name}`"></q-btn>
        </q-card-actions>
      </q-card>
    </div>
    <CardHome :data="data" v-for="(data, i) in destaques" :key="`i-${i}`" :index="`i-${i}`"/>
    
    
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
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
    QAvatar
  },

  data() {
    return {
      destaques: []
    };
  },
  computed: {
    ...mapState(["disciplinas"])
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
<style lang="scss" scoped>
</style>
