<template>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-deslizante" aria-expanded="false">
                <span class="sr-only">Menu deslizante</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img class="logo pull-left" alt="Logo da plataforma" src="/logo.svg" width="30" height="30">
                    <span class="name pull-left hidden-xs">Plataforma Anísio Teixeira</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="menu-deslizante">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          Canais <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <router-link v-for="(link,i) in links" 
                                  :key="i" 
                                  tag="li" 
                                  :to="{ name: 'Listar', params: {slug: link.slug}}">
                               <a>{{link.name}}</a>
                            </router-link>
                            
                            <li role="separador" class="divider" v-if="isLogged"></li>
                            <router-link tag="li" :to=" {name:'admin', params: { slug: 'inicio', action:'estatisticas' }}" v-if="isLogged">
                                <a>Administração</a>
                            </router-link>
                        </ul>
                    </li>
                    <li class="dropdown pading-rigth-30">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-user"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <router-link tag="li" to="/usuario/login" v-if="!isLogged">
                                <a>Login</a>
                            </router-link>
                            <router-link tag="li" 
                                        :to=" { name:'admin', params: { slug: 'usuarios', action:'alterar-senha' }}" 
                                        v-if="isLogged">
                                <a class="pointer">Alterar senha</a>
                            </router-link>
                            <li role="separador" class="divider" v-if="isLogged"></li>
                            <li v-if="isLogged">
                                <a class="pointer" v-on:click.prevent="sair()">Sair</a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="progress-container">
            <div class="progress-bar" id="bar" :style="color"></div>
        </div>
    </nav>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  name: "NavPricipal",
  computed: {
    ...mapState(["isLogged", "links", "canal"]),
    color() {
      return this.canal.hasOwnProperty("options")
        ? `background:${this.canal.options.color}!important;`
        : "background: #1e78c2;";
    }
  },
  methods: {
    ...mapActions(["logout"]),
    sair() {
      this.logout().then(() => {
        if (!this.isLogged) {
          this.$router.push("/");
        }
      });
    },
    handleScroll() {
      let winScroll =
        document.body.scrollTop || document.documentElement.scrollTop;
      let height =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      var scrolled = winScroll / height * 100;
      document.getElementById("bar").style.width = scrolled + "%";
    }
  },
  created() {
    window.addEventListener("scroll", this.handleScroll, { passive: true });
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll, { passive: true });
  }
};
</script>
<style lang="scss" scoped>
.logo {
  width: 30px;
  height: 30px;
}
.name {
  font-size: 20px;
  color: #333;
  padding-top: 5px;
  display: block;
}
.progress-container {
  width: 100%;
  height: 2px;
  background: #ccc;
}
.progress-bar {
  height: 2px;
  background: #1e78c2;
  width: 0%;
}
.pading-rigth-30 {
  margin-right: 20px;
}
</style>