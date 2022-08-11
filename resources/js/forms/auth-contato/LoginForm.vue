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
              autocomplete="on"
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
            <RecaptchaForm :errors="errors.recaptcha"></RecaptchaForm>
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
// @ts-nocheck

import { mapActions, mapState } from "vuex";
import { RecaptchaForm, ShowErrors } from "@/forms/shared";
import {
  QCard,
  QCardSection,
  QCardActions,
  QInput,
  QForm,
  QImg,
  QSeparator,
  QSpace,
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
    QSpace,
    RecaptchaForm,
  },
  data() {
    return {
      email: null,
      password: null,
      isPwd: true,
      errors: {},
    };
  },
  computed: {
    ...mapState(["isLogged"]),
  },
  methods: {
    ...mapActions(["login"]),
    async onSubmit() {
      this.$q.loading.show();
      this.errors = {};

      let credentials = {
        email: this.email,
        password: this.password,
        recaptcha: grecaptcha.getResponse(),
      };

      let { redirect, errors } = await this.login(credentials);
      if (redirect) {
        this.$q.loading.hide();
        axios.defaults.headers.common.Authorization = `Bearer ${localStorage.token}`;
        this.$router.replace("/admin/conteudos/listar");
      }
      this.errors = errors;
      this.$q.loading.hide();
      grecaptcha.reset();
    },
  },
};
</script>
