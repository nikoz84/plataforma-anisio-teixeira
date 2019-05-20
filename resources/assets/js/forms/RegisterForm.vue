<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
            <form v-on:submit.prevent="register()">
                
                <div class="panel panel-default col-md-7">
                    <div class="panel-heading">
                        Crie uma conta
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nome do usuário" v-model="user.name">
                            <small class="text-info">Escreva seu nome</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" aria-describedby="seu email" v-model="user.email">
                            <small class="text-info">Escreva seu e-mail</small>
                        </div>
                        <!-- Nova senha -->
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" aria-describedby="senha" v-model="user.password">
                            <small class="text-info">Escreva uma senha</small>
                        </div>
                        <div class="form-group">
                            <label for="confirmasenha">Repita a Senha</label>
                            <input type="password" class="form-control" id="confirmasenha" aria-describedby="confirmar senha" v-model="user.password_confirmation">
                            <small class="text-info">Confirme sua senha</small>
                        </div>
                        <AlertShake></AlertShake>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default">Enviar</button>
                    </div>
                    <router-link to="/usuario/login">
                        Login
                    </router-link> | 
                    <router-link to="/usuario/recuperar-senha">
                        Recuperar Senha
                    </router-link>
                </div>
                
            </form>
            
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import AlertShake from "../components/AlertShakeComponent.vue";

export default {
  name: "RegisterForm",
  components: { AlertShake },
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      }
    };
  },
  computed: {
    ...mapState(["isError"])
  },
  mounted() {
    //
  },
  methods: {
    ...mapActions(["registerUser"]),
    register() {
      this.registerUser(this.user).then(() => {
        if (!this.isError) {
          this.$router.push("/usuario/login");
        }
      });
    }
  }
};
</script>