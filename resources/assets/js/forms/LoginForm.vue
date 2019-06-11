<template>
  <section class="row">
    <div class="form-image">
      <div class="bottom-0">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title text-center">Faça seu Login</h4>
            </div>
            <div class="panel-body">
                <form v-on:submit.prevent="entrar()">
                    <div class="form-group" v-bind:class="inputErrors('email')">
                        <label for="email">E-mail</label>
                        <input class="form-control" v-model="email" id="email" type="text">
                        <ShowErrors :errors="errors.email"></ShowErrors>
                    </div>
                    <div class="form-group" v-bind:class="inputErrors('password')">
                        <label for="senha">Senha</label>
                        <input class="form-control" v-model="password" id="senha" type="password">
                        <ShowErrors :errors="errors.password"></ShowErrors>
                    </div>
                    <button type="submit" class="btn btn-default btn-block">Login</button>
                </form>
                <AlertShake></AlertShake>
                <div class="text-center links">
                  <router-link to="/usuario/recuperar-senha">
                    Recuperar senha
                  </router-link> |
                  <router-link to="/usuario/registro">
                      Cadastre-se
                  </router-link>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";
import AlertShake from "../components/AlertShake.vue";
import ShowErrors from "../components/ShowErrors.vue";
import { getInputError } from "../functions.js";

export default {
  name: "LoginForm",
  components: {
    AlertShake,
    ShowErrors
  },
  data() {
    return {
      email: null,
      password: null
    };
  },
  beforeCreate() {
    if (!this.isLogged) {
      this.$router.push("/usuario/login");
    }
  },
  computed: {
    ...mapState(["isLogged", "errors"])
  },
  methods: {
    ...mapActions(["login"]),
    entrar() {
      let data = { email: this.email, password: this.password };

      this.login(data).then(() => {
        if (this.isLogged) {
          this.docodePayloadToken();
          this.$router.push("/admin/inicio/estatisticas");
        }
      });
    },
    inputErrors(attr) {
      return getInputError(this.errors, attr);
    },
    docodePayloadToken() {
      const base64Url = localStorage.token.split(".")[1];
      const base64 = base64Url.replace("-", "+").replace("_", "/");
      let payload = JSON.parse(window.atob(base64));
      localStorage.setItem("username", payload.user.name);
      localStorage.setItem("user_id", payload.user.id);
    }
  }
};
</script>
<style lang="scss" scoped>
$break-small: 780px;
$break-large: 781px;
$break-extra-large: 1200px;

.form-image{
  display: block;
  min-height: 100vh;
  padding: 0;
  background: url("/storage/conteudos/conteudos-digitais/galeria/2.jpg") no-repeat bottom center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;

  .bottom-0{
    @media screen and (max-width: $break-small) {
      position: absolute;
      left: 60px;
      width: 60vh;
      margin-top: 50px;
    }
    @media screen and (min-width: $break-large) {
      position: absolute;
      bottom: 0px;
      right: 5px;
      min-width: 360px;
    }
    @media screen and (min-width: $break-extra-large) {
      position: absolute;
      bottom: 0px;
      right: 15px;
      min-width: 420px;
    }
  }
  form{
    padding-left: 15px;
    padding-right: 15px;
  }
}
.links {
  padding-top: 15px;
}

</style>
