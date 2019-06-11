<template>
    <div class="row">
      <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs" style="margin-top: 20px;">
        <div class="panel panel-default col-md-7">
            <div class="panel-heading">
                Faça seu Login
            </div>
            <div class="panel-body">
                <form v-on:submit.prevent="entrar()">
                    <div class="form-group" v-bind:class="showErrors('email')">
                        <label for="email">E-mail</label>
                        <input class="form-control" v-model="email" id="email" type="text">
                        <erros :errors="errors.email"></erros>
                    </div>
                    <div class="form-group" v-bind:class="showErrors('password')">
                        <label for="senha">Senha</label>
                        <input class="form-control" v-model="password" id="senha" type="password">
                        <erros :errors="errors.password"></erros>
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
                <AlertShake></AlertShake>
                <router-link to="/usuario/recuperar-senha">
                    Recuperar senha
                </router-link> |
                <router-link to="/usuario/registro">
                    Cadastrese
                </router-link>
            </div>
        </div>
      </div>
    </div>
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";
import AlertShake from "../components/AlertShake.vue";
import showErrors from "../components/ShowErrors.vue";
import { getInputError } from "../functions.js";

export default {
  name: "LoginForm",
  components: {
    AlertShake,
    erros: showErrors
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
    showErrors(attr) {
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

.row{
    display: block;
    width: 100vw;
    height: 100vh;
    padding: 0;
    background: url("/storage/conteudos/conteudos-digitais/galeria/2.jpg") no-repeat bottom center scroll;    
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
    
}

form {
  margin-top: 30px;
  margin-bottom: 30px;
}
</style>
