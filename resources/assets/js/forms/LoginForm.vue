<template>
  <article>
     <IntroParallax/>
    <div class="row">
        <q-card class="offset-md-4 col-md-4">
            <q-card-section >
                <div class="text-center text-h5">Faça seu Login</div>
            </q-card-section>
            <q-separator inset />
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
                   <div>
                     <q-btn class="full-width" label="Entrar" type="submit" color="primary"/>
                   </div>
                </q-form>
                
                <div class="text-center q-mt-lg">
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
  </article>
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";
import { QCard, QCardSection, QInput, QForm, QImg, QSeparator } from "quasar";
import ShowErrors from "../components/ShowErrors.vue";
import IntroParallax from "../components/IntroParallax.vue";

export default {
  name: "LoginForm",
  components: {
    QCard,
    QCardSection,
    ShowErrors,
    QForm,
    QInput,
    QImg,
    IntroParallax
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
    ...mapMutations(["SET_ERRORS", "SET_LOGIN_USER"]),
    async onSubmit() {
      this.$q.loading.show();
      let data = { email: this.email, password: this.password };
      let resp = await axios.post("/auth/login", data);

      if (resp.data && resp.data.success) {
        this.$q.loading.hide();
        localStorage.setItem("token", resp.data.metadata.token.access_token);
        this.docodePayloadToken();
        this.SET_ERRORS([]);
        this.SET_LOGIN_USER(true);

        this.$router.push("/admin/conteudos/listar");

        this.$q.notify({
          color: "positive",
          textColor: "white",
          icon: "done",
          message: `${resp.data.message} ${localStorage.username}!!`
        });
        setTimeout(() => {
          window.location.reload(true);
        }, 150);
      } else {
        this.SET_ERRORS(resp.data.errors);
        this.$q.loading.hide();

        this.$q.notify({
          color: "negative",
          textColor: "white",
          icon: "error",
          message: resp.data.message
        });
      }
    },
    docodePayloadToken() {
      const base64Url = localStorage.token.split(".")[1];
      const base64 = base64Url.replace("-", "+").replace("_", "/");
      let payload = JSON.parse(window.atob(base64));

      localStorage.setItem("username", payload.user.name);
      localStorage.setItem("user_id", payload.user.id);
      localStorage.setItem("sexo", payload.user.sexo);
    }
  }
};
</script>
