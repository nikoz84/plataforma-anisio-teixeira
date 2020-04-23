<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <q-card-section>
          <div class="text-center text-h5">Faça seu Login</div>
        </q-card-section>
        <q-separator inset />
        <q-card-section>
          <q-form
            @submit.prevent="onSubmit()"
            class="q-gutter-md"
            ref="loginForm"
          >
            <q-input
              filled
              v-model="email"
              label="Seu E-mail *"
              hint="E-mail"
              type="email"
              bottom-slots
              :error="errors.email && errors.email.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.email"></ShowErrors>
              </template>
            </q-input>
            <q-input
              v-model="password"
              filled
              :type="isPwd ? 'password' : 'text'"
              hint="Senha"
              bottom-slots
              :error="errors.password && errors.password.length > 0"
            >
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
              <q-btn
                class="full-width"
                label="Entrar"
                type="submit"
                color="primary"
              />
            </div>
          </q-form>
        </q-card-section>
        <q-card-actions align="around">
          <q-btn flat to="/usuario/recuperar-senha">Recuperar senha</q-btn>
          <q-btn flat to="/usuario/registro">Cadastre-se</q-btn>
        </q-card-actions>
      </q-card>
    </div>
  </article>
</template>
<script>
import ShowErrors from "../components/ShowErrors.vue";
import { mapActions, mapState, mapMutations } from "vuex";
import {
  QCard,
  QCardSection,
  QCardActions,
  QInput,
  QForm,
  QImg,
  QSeparator,
  QSpace
} from "quasar";

export default {
  name: "LoginForm",
  components: {
    QCard,
    QCardSection,
    QCardActions,
    ShowErrors,
    QForm,
    QInput,
    QSeparator,
    QSpace
  },
  data() {
    return {
      email: null,
      password: null,
      isPwd: true,
      errors: {}
    };
  },
  computed: {
    ...mapState(["isLogged"])
  },
  methods: {
    ...mapActions(["login"]),
    ...mapMutations(["SET_LOGIN_USER"]),
    async onSubmit() {
      this.$q.loading.show();
      this.errors = {};

      let data = { email: this.email, password: this.password };
      try {
        let resp = await axios.post("/auth/login", data);
        
        this.login(resp.data);
      } catch (response) {
        this.errors = response.errors;
      }
    },
    login(resp) {
      this.$q.loading.hide();
      const jwtToken = resp.metadata.access_token;

      this.$q.localStorage.set("token", jwtToken);
      this.docodePayloadToken();
      this.SET_LOGIN_USER(true);
      axios.defaults.headers.common["Authorization"] = `Bearer ${jwtToken}`;

      this.$router.replace("/admin/conteudos/listar");
    },
    docodePayloadToken() {
      const base64Url = localStorage.token.split(".")[1];
      const base64 = base64Url.replace("-", "+").replace("_", "/");
      let payload = JSON.parse(window.atob(base64));

      localStorage.setItem("user", JSON.stringify(payload.user.name));
      
    }
  }
};
</script>
