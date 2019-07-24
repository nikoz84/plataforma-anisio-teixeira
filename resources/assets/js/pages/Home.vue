<template>
  <section class="row">
    <!--SideBarHome/-->
    <CardHome :data="data" v-for="(data, i) in destaques" :key="`i-${i}`"/>
    
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
      destaques: [],
    };
  },
  beforeMount() {
    this.getData();
  },
  mounted() {
    
  },
  methods: {
    async getData() {
      let resp = await axios.get("/destaques");
      console.log(resp.data.metadata)
      if (resp.status == 200 && resp.data.success) {
        this.destaques = resp.data.metadata
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