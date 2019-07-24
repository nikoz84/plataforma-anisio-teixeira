<template>
  <section>
    <!--SideBarHome/-->
    <article class="row justify-between">
      <q-parallax style="min-height:100vh;">
        <template v-slot:media>
          <img src="/storage/conteudos/slider/banner-blog.jpg">
        </template>

        <template v-slot:content="scope">
          <div class="absolute column items-center"
            :style="{ opacity: 0.45 + (1 - scope.percentScrolled) * 0.55, top: (scope.percentScrolled * 60) + '%', left: 0, right: 0 }"
          >
            <img src="/logo.svg" style="width: 150px; height: 150px">
            <div class="text-h3 text-primary text-center">Plataforma Anísio Teixeira</div>
            <div class="text-h6 text-dark text-center">
              v3.0.0
            </div>
          </div>
        </template>
      </q-parallax>
    </article>
    <article class="row justify-between">
      <q-parallax src="/storage/conteudos/slider/andressa-falcc3a3o.jpg" style="min-height:100vh;">
        <template v-slot:content="scope">
          <div class="absolute column items-center">
            <img src="/logo.svg" style="width: 150px; height: 150px">
            <div class="text-h3 text-primary text-center">Destaque do Blog</div>
          </div>
        </template>
      </q-parallax>
    </article>
    <article class="row justify-between">
      <q-parallax src="/storage/conteudos/conteudos-digitais/galeria/4.jpg" style="min-height:100vh;">
        <template v-slot:content="scope">
          <div class="absolute column items-center">
            <img src="/logo.svg" style="width: 150px; height: 150px">
            <div class="text-h3 text-primary text-center">Outro destaque da Plataforma</div>
          </div>
        </template>
      </q-parallax>
    </article>

    <CardHome :data="data" v-for="(data, i) in destaques" :key="`i-${i}`"/>
    
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
//import SideBarHome from "../components/SideBarHome.vue";
import { QParallax } from "quasar";

export default {
  name: "Home",
  components: {
    QParallax,
    CardHome
    //SideBarHome
  },

  data() {
    return {
      destaques: []
    };
  },
  beforeMount() {
    this.getData();
  },
  mounted() {},
  methods: {
    async getData() {
      let resp = await axios.get("/destaques");
      console.log(resp.data.metadata);
      if (resp.status == 200 && resp.data.success) {
        this.destaques = resp.data.metadata;
      }
    }
  },
  destroyed() {
    // window.removeEventListener("scroll", this.handleLoadScroll);
  }
};
</script>
<style lang="scss" scoped>
</style>