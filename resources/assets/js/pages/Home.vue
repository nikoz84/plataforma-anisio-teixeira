<template>
  <div class="container-fluid no-padding">
    <section class="row">
      <!-- SideBarHome class="col-md-3"></!-->
      <div class="load heigth" 
                v-for="(item, index) in items" 
                :key="index" :id="item" style="background-color: #49255b;border:solid 1px #000;">
      </div>
    </section>
  </div>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import SideBarHome from "../components/SideBarHome.vue";

export default {
  name: "Home",
  components: {
    CardHome,
    SideBarHome
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
      current: ""
    };
  },
  mounted() {
    //this.getData();
    /*
    let elements = document
      .getElementById("main-home")
      .getElementsByClassName("load");

    for (let el of elements) {
      let ele = document.getElementById(el.id);
      console.log(ele.scrollTop, ele.scrollLeft);
    }
    */
    window.addEventListener("scroll", this.handleLoadScroll, { passive: true });
  },
  methods: {
    async getData() {
      let resp = await axios.get("/destaques");
      if (resp.status == 200 && resp.data) {
        //this.data = resp.data;
      }
    },
    async handleLoadScroll() {
      var scrollLeft =
          window.pageXOffset || document.documentElement.scrollLeft,
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      //console.log(scrollLeft, scrollTop);
    }
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleLoadScroll, {
      passive: true
    });
  }
};
</script>
<style lang="scss" scoped>
#main-home {
  transition: margin-left 0.5s;
}

.no-padding {
  padding: 0 0 50px 0;
}
</style>