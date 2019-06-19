<template>
  <div class="row">
    <div class="form-image">
      <div class="bottom-0">
        <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
          <form v-on:submit.prevent="register()">
            <div class="panel panel-default col-md-7">
              <div class="panel-heading">
                  Crie uma conta
              </div>
              <div class="panel-body">
                <div class="form-group" :class="showErrors('name')">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" 
                            aria-describedby="nome do usuário" v-model="name">
                    <small class="text-info">Escreva seu nome</small>
                    <erros :errors="errors.name"></erros>
                </div>
                <div class="form-group" :class="showErrors('email')">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" aria-describedby="seu email" v-model="email">
                    <small class="text-info">Escreva seu e-mail</small>
                    <erros :errors="errors.email"></erros>
                </div>
                <!-- Nova senha -->
                <div class="form-group" :class="showErrors('password')">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" aria-describedby="senha" v-model="password">
                    <small class="text-info">Escreva uma senha</small>
                    <erros :errors="errors.password"></erros>
                </div>
                <div class="form-group" :class="showErrors('confirmation')">
                    <label for="confirmasenha">Repita a Senha</label>
                    <input type="password" class="form-control" 
                        id="confirmasenha" aria-describedby="confirmar senha" 
                        v-model="confirmation">
                    <small class="text-info">Confirme sua senha</small>
                    <erros :errors="errors.confirmation"></erros>
                </div>
                <AlertShake></AlertShake>
                <div class="form-group">
                    <button class="btn btn-default btn-block">Enviar</button>
                </div>
                <div class="links text-center">
                  <router-link to="/usuario/login">
                    Login
                  </router-link> | 
                  <router-link to="/usuario/recuperar-senha">
                      Recuperar Senha
                  </router-link>  
                </div>
              </div>
            </div>
          </form>
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
  name: "RegisterForm",
  components: { AlertShake, erros: showErrors },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmation: ""
    };
  },
  computed: {
    ...mapState(["isError", "errors"])
  },
  mounted() {
    //
  },
  methods: {
    ...mapActions(["registerUser"]),
    ...mapMutations(["SET_ERRORS", "SET_IS_ERROR"]),
    register() {
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        confirmation: this.confirmation
      };

      this.registerUser(data).then(() => {
        if (!this.isError) {
          this.SET_ERRORS({});
          this.SET_IS_ERROR(false);
          this.$router.push("/usuario/login");
        }
      });
    },
    showErrors(attr) {
      return getInputError(this.errors, attr);
    }
  }
};
</script>
<style lang="scss" scoped>
.form-image {
  display: block;
  min-height: 100vh;
  padding: 0;
  background: url("/storage/conteudos/conteudos-digitais/galeria/5.jpg")
    no-repeat bottom center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;

  form {
    padding-left: 15px;
    padding-right: 15px;
  }
}
.links {
  padding-top: 15px;
}
</style>
