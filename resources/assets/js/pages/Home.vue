<template>
  <div class="container-fluid no-padding">
    <section class="row">
      <!-- SideBarHome class="col-md-3"></!-->
      <div class="load">
        <div class=" heigth" 
                style="background-color: #49255b;border:solid 1px #000;"
                v-infinite-scroll="loadMore"
                infinite-scroll-disabled="busy"
                infinite-scroll-distance="10">
      </div>
      </div>
      
    </section>
  </div>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import SideBarHome from "../components/SideBarHome.vue";
import debounce from "lodash/debounce";

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
      blocks: null,
      busy: false
    };
  },
  watch: {
    termo(novo, antigo) {
      debounce(this.handleLoadScroll(), 20);
    }
  },
  beforeMount() {
    this.getData("conteudos_recentes");
  },
  mounted() {
    this.blocks = document.querySelectorAll(".load");
  },
  methods: {
    async getData(get) {
      let resp = await axios.get("/destaques", { get });
      console.log(resp);
      if (resp.status == 200 && resp.data) {
        //this.data = resp.data;
      }
    },
    async loadMore() {
      let items = this.blocks ? this.blocks : [];
      var self = this;
      self.busy = true;
      const load = document.querySelector(".load");
      //console.log("loading... " + new Date());
      setTimeout(function() {
        var height = load.clientHeight;
        load.style.height = height + 300 + "px";
        console.log("end... " + new Date());
        self.busy = false;
      }, 1000);
      /*
      items.forEach(item => {
        console.log(item.offsetTop);
        console.warn(window.pageYOffset);
        if (item.offsetTop == window.pageYOffset) {
          //console.warn(item.id);
        }
      });
      */
    }
  },
  destroyed() {
    // window.removeEventListener("scroll", this.handleLoadScroll);
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
.align-right {
  float: right;
  margin-right: 20px;
}
.align-left {
  float: left;
  margin-left: 20px;
}
.slide-in {
  opacity: 0;
  transition: all 0.5ms;
}
.align-left.slide-in {
  transform: translate(-30%) scale(0.95);
}
.align-right.slide-in {
  transform: translate(30%) scale(0.95);
}
.slide-in.active {
  opacity: 1;
  transform: translateX(0%) scale(1);
}
</style>