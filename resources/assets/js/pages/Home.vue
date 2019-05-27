<template>

  <section class="container-fluid heigth">
    <section class="main" id="main-home">
      <menu-side-bar class="col-sm-3"></menu-side-bar>
      <div class="col-sm-9">
        <CardHome :title="'Conteúdos Mais Baixados'" :items="data.conteudos_baixados"></CardHome>
        <CardHome :title="'Conteúdos Mais Acessados'" :items="data.conteudos_acessados"></CardHome>
        <CardHome :title="'Aplicativos Destacados'" :items="data.aplicativos_destaque"></CardHome>
      </div>
    </section>
  </section>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import CardHome from "../components/CardHome.vue";
import MenuSideBar from "../components/MenuSideBar.vue";

export default {
  name: "Home",
  components: {
    CardHome,
    "menu-side-bar": MenuSideBar
  },

  data() {
    return {
      data: {}
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      let resp = await axios.get("/destaques");
      console.log(resp);
      this.data = resp.data;
    }
  }
};
</script>
<style lang="scss" scoped>
.texto h1 {
  color: #ffffff;
  font-size: 30px;
  font-weight: bold;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.texto p {
  color: #ffffff;
  font-size: 15px;
  text-align: justify;
  margin: 10px;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
}
.texto ul {
  margin: 5px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main-home {
  transition: margin-left 0.5s;
  padding: 20px;
  min-height: 90vh;
}
.box-shadow {
  -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}
.no-padding {
  padding: 0;
}
.container-fluid .btn-flutuante {
  position: fixed;
  left: 1rem;
  top: 1rem;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {
    padding-top: 15px;
  }
  .sidebar a {
    font-size: 18px;
  }
}
</style>