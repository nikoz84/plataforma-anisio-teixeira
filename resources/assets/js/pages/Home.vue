<template>
  <section >
    <article>
      <q-banner style="min-height:50vh;">
        <template v-slot:avatar>
          <div class="absolute column items-center">
            <img src="/logo.svg" style="width: 150px; height: 150px;" class="load" v-scroll-fire="getDestaques">
            <div class="text-5 text-primary text-center">Plataforma Anísio Teixeira\zx\zx\zx</div>
          </div>
	<h6>{{itens}}</h6>
        </template>
      </q-banner>
	
    </article>
        
    <CardHome :data="data" v-for="(data, i) in destaques" :key="`i-${i}`"/>
    
    
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import { QParallax, ScrollFire, QBanner } from "quasar";

export default {
  name: "Home",
  directives: {
    ScrollFire
  },
  components: {
    QParallax,
    CardHome,
    QBanner
  },

  data() {
    return {
      destaques: [],
      itens: 'hola mundo'
    };
  },
  created() {},
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
