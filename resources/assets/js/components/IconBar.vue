<template>
  <div class="icon-bar afix" data-spy="affix" data-offset-bottom="50%">
    <a @click.prevent="openSidebar()">
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a href="javascript:history.go(-1)">
      <i class="glyphicon glyphicon-arrow-left"></i>
    </a>
    <a @click.prevent="add()" v-if="isLogged && $route.params.slug">
      <i class="glyphicon glyphicon-plus"></i>
    </a>
    <a @click.prevent="update()" v-if="isLogged && $route.params.id">
      <i class="glyphicon glyphicon-edit"></i>
    </a>  
    <a @click.prevent="remove()" v-if="isLogged && $route.params.id">
      <i class="glyphicon glyphicon-trash"></i>
    </a>
    
  </div>
  
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "OpenSideBar",
  watch: {
    $route(to, from) {
      console.log(to);
      console.log(this.action);
    }
  },
  computed: {
    ...mapState(["isLogged", "action"])
  },
  methods: {
    openSidebar() {
      document.getElementById("sidebar-home").style.width = "100%";
    },
    add() {
      let url = `/${this.$route.params.slug}/adicionar`;
      console.log(url);
    },
    update() {
      let url = `/${this.$route.params.slug}/editar/${this.$route.params.id}`;
      console.log(url);
    },
    remove() {
      let url = `/${this.$route.params.slug}/deletar/${this.$route.params.id}`;
      console.log(url);

      /*
      //lista os conteúdos
      if (resp.data.success) {
        this.$router.push({
          name: "Listar",
          params: { slug: this.$route.params.slug }
        });
      }
      */
    }
  }
};
</script>
<style lang="scss" scoped>
.icon-bar {
  width: 42px;
  background-color: #010e1b;
  background-color: rgba(1, 14, 27, 0.7);
  opacity: 0.8;
  z-index: 150 !important;
}

.icon-bar a {
  display: block;
  text-align: center;
  cursor: pointer;
  padding: 5px;
  transition: all 0.3s ease;
  color: white;
  font-size: 20px;
  .glyphicon {
    color: white;
    font-size: 20px;
  }
}

.icon-bar a:hover {
  background-color: #2196f3;
}

.affix {
  top: 14vh;
  right: 0px;
}
</style>