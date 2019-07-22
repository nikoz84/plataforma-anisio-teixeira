<template>
  <section class="row">
    <!-- SideBarHome class="col-md-3"></!-->
asdasdasd
    
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
//import SideBarHome from "../components/SideBarHome.vue";

export default {
  name: "Home",
  components: {
    CardHome,
    //SideBarHome
  },

  data() {
    return {
      data: {},
      items: [
        "conteudos_recentes",
        "conteudos_baixados",
        "conteudos_acessados",
        "conteudos_destacados",
        "aplicativos_recentes",
        "aplicativos_destacados"
      ],
      blocks: null,
      busy: false
    };
  },
  beforeMount() {
    this.getData("conteudos_recentes");
  },
  mounted() {
    
  },
  methods: {
    async getData(get) {
      let resp = await axios.get("/destaques", { get });
      console.log(resp)
      if (resp.status == 200 && resp.data) {
        //this.data = resp.data;
      }
    },
    
  },
  destroyed() {
    // window.removeEventListener("scroll", this.handleLoadScroll);
  }
};
</script>
<style lang="scss" scoped>

</style>