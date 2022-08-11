<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card style="min-width:350px;">
        <q-card-section>
          <div class="text-center text-h5">Recuperar Senha</div>
          <div class="q-mt-md text-center">
            Por favor, verifique na sua conta de email um correio de verificação
            para recuperar sua senha,
            <b class="text-info">é possível achar esse email no spam</b>
          </div>
        </q-card-section>
        <q-separator inset />
        <q-card-section v-if="show">
          <q-input
            filled
            label="Escreva seu e-mail"
            v-model="email"
            type="email"
            :error="errors && errors.email && errors.email.length > 0"
            bottom-slots
          >
            <template v-slot:error>
              <ShowErrors :errors="errors.email"></ShowErrors>
            </template>
          </q-input>
        </q-card-section>
        <q-card-section v-if="show">
          <RecaptchaForm :errors="errors.recaptcha"></RecaptchaForm>
        </q-card-section>
        <q-card-section v-if="show">
          <q-btn
            color="primary"
            class="full-width"
            @click="send()"
            :loading="loading"
            label="Enviar"
          ></q-btn>
        </q-card-section>
        <q-card-section v-else>
          <div class="text-center text-h6">
            Obrigado, no email enviaremos um link para recuperar sua senha.
          </div>
        </q-card-section>
      </q-card>
    </div>
  </article>
</template>

<script>
import { RecaptchaForm, ShowErrors } from "@/forms/shared";

export default {
  name: "RecoverPassForm",
  components: { RecaptchaForm, ShowErrors },
  data() {
    return {
      email: null,
      errors: [],
      show: true,
      loading: false,
    };
  },
  methods: {
    async send() {
      this.loading = true;
      const form = new FormData();
      form.append("email", this.email);
      form.append("recaptcha", grecaptcha.getResponse());
      try {
        let { data } = await axios.post("/auth/recuperar-senha", form);
        this.loading = false;
        if (data.success) {
          this.show = false;
        }
      } catch (e) {
        this.errors = e.errors;
        this.loading = false;
      }
    },
  },
};
</script>

<style></style>
