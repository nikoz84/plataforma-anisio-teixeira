<template>
  <section class="row q-pa-sm">
    
	  <div class="q-gutter-sm load" v-scroll-fire="getDestaques"> 
      <q-card v-for="(disciplina, i) in disciplinas.components" :key="`d-${i}`">
        <q-item clickable>
          <q-item-section avatar>
            <q-avatar>
              <img rounded-borders :title="disciplina.name" :src="`/storage/conteudos/conteudos-digitais/imagem-associada/emitec/ico-${disciplina.id}.svg`" >
            </q-avatar>
          </q-item-section>
          <q-item-section >
            <q-item-label>
              {{disciplina.name}}
            </q-item-label>
          </q-item-section>
        </q-item>
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
  QItem,
  QItemSection,
  QItemLabel,
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
    QItem,
    QItemSection,
    QItemLabel,
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
