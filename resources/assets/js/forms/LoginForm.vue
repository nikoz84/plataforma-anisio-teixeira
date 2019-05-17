<template>
    <div class="row">
      <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
        <div class="panel panel-default col-md-7">
            <div class="panel-heading">
                Faça seu Login
            </div>
            <div class="panel-body">  
                <form v-on:submit.prevent="login(user)">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" v-model="user.email" id="email" type="text">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input class="form-control" v-model="user.password" id="senha" type="password">
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
                <router-link to="/usuario/recuperar-senha">
                    Recuperar senha
                </router-link> | 
                <router-link to="/usuario/registro">
                    Cadastrese 
                </router-link>
        
                <transition  name="custom-classes-transition" 
                            enter-active-class="animated shake" 
                            leave-active-class="animated fadeOut">
                <div v-if="isError" class="alert alert-info" role="alert" v-text="textAlert"></div>
                </transition>
            </div>
        </div>    
      </div>
    </div> 
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";

export default {
  name: "LoginForm",
  data() {
    return {
      user: {
        email: null,
        password: null
      }
    };
  },
  beforeCreate() {
    if (!this.isLogged) {
      this.$router.push("/usuario/login");
    }
  },
  computed: {
    ...mapState(["isError", "isLogged", "textAlert"])
  },
  methods: {
    ...mapActions(["login"]),
    ...mapMutations(["SET_IS_ERROR", "SET_LOGIN_USER"]),
    showMessage() {
      if (this.isError) {
        //this.$router.push("/usuario/login");
      } else {
        this.docodePayloadToken();
        this.SET_LOGIN_USER(true);
        this.$router.push("/admin");
      }
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
form {
  margin-top: 30px;
  margin-bottom: 30px;
}
</style>
