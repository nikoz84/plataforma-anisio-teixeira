<template>
  <article>
     <div class="row">
      <q-parallax src="/storage/conteudos/conteudos-digitais/galeria/2.jpg" style="max-height:50vh;">
        <template v-slot:content="scope">
          <div class="absolute-bottom-rigth column items-center">
            <div class="text-h6 text-white text-center">
              <router-link tag="div" to="/galeria" style="background-color: hsla(218, 84%, 20%, 0.8); padding: 15px;cursor: pointer;">
                <q-icon name="photo" class="cursor-pointer"/>
                Visite nossa galeria de imagens
              </router-link>
            </div>
          </div>
        </template>
      </q-parallax>
    </div>
    <div class="row">
      <div>
        <q-card>
            <q-card-section >
                <div class="text-center text-h5">Faça seu Login</div>
            </q-card-section>
            <q-card-section>
                <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="loginForm">
                  <q-input filled v-model="email" label="Seu E-mail *" hint="E-mail" type="email"
                                bottom-slots :error="errors.email && errors.email.length > 0">
                    <template v-slot:error>
                      <ShowErrors :errors="errors.email"></ShowErrors>
                    </template>
                  </q-input>
                  <q-input v-model="password" filled :type="isPwd ? 'password' : 'text'" hint="Senha"
                            bottom-slots :error="errors.password && errors.password.length > 0">
                    <template v-slot:append>
                      <q-icon
                        :name="isPwd ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd = !isPwd"
                      />
                    </template>
                    <template v-slot:error>
                      <ShowErrors :errors="errors.password"></ShowErrors>
                    </template>
                  </q-input>
 
                        
                    
                    <button type="submit" class="btn btn-default btn-block">Login</button>
                </q-form>
                
                <div class="text-center links">
                  <router-link to="/usuario/recuperar-senha">
                    Recuperar senha
                  </router-link> |
                  <router-link to="/usuario/registro">
                      Cadastre-se
                  </router-link>
                </div>
            </q-card-section>
        </q-card>
      </div>
    </div>
  </article>
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";
import { QParallax, QCard, QCardSection, QInput, QForm } from "quasar";
import ShowErrors from "../components/ShowErrors.vue";

export default {
  name: "LoginForm",
  components: {
    QParallax,
    QCard,
    QCardSection,
    ShowErrors,
    QForm,
    QInput
  },
  data() {
    return {
      email: null,
      password: null,
      isPwd: true
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
          this.$router.push({
            name: "admin",
            params: { slug: "analytics", action: "listar" }
          });
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

.form-image {
  display: block;
  min-height: 100vh;
  padding: 0;
  background: url("/storage/conteudos/conteudos-digitais/galeria/2.jpg")
    no-repeat bottom center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;

  .bottom-0 {
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
  form {
    padding-left: 15px;
    padding-right: 15px;
  }
}
.links {
  padding-top: 15px;
}
</style>
