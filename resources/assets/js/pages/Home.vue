<template>
  <section>
    <!--SideBarHome/-->
    <article class="row justify-between">
      <q-parallax src="/storage/conteudos/slider/banner-blog.jpg" style="min-height:100vh;">
        <div class="absolute-bottom text-subtitle2"> 
            <h1 class="text-secondary">Plataforma Anísio Teixeira 3.0</h1>
        </div>
      </q-parallax>
    </article>
    <article class="row justify-between">
      <q-parallax src="/storage/conteudos/slider/andressa-falcc3a3o.jpg" style="min-height:100vh;">
        <h1 class="text-white"> DESTAQUES </h1>
      </q-parallax>
    </article>
    <article class="row justify-between">
      <q-parallax src="/storage/conteudos/slider/andressa-falcc3a3o.jpg" style="min-height:100vh;">
        <h1 class="text-white"> TEXTO </h1>
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