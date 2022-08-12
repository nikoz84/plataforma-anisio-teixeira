<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
      <q-card class="col-sm-6">
        <q-card-section>
          <div class="text-center text-h5">
            Verificar Email
          </div>
        </q-card-section>
        <q-card-section>
          <q-input
            v-model="token"
            :loading="loadingState"
            :hint="hint"
          ></q-input>
        </q-card-section>

        <q-card-actions align="around">
          <q-btn color="primary" flat @click="verify" label="Verificar"></q-btn>
        </q-card-actions>
      </q-card>
    </div>
  </article>
</template>
<script>
import { ShowErrors } from "@/forms/shared";

export default {
  name: "ConfirmationEmailForm",
  components: { ShowErrors },
  data() {
    return {
      token: null,
      loadingState: false,
      errors: {},
      hint:
        "Espere em sua conta de e-mail pelo código de verificação, e cole aquí",
    };
  },
  methods: {
    async verify() {
      if (!this.token) return;
      this.loadingState = true;

      await axios
        .get(`/auth/verificar/email/${this.token}`)
        .then(({ data }) => {
          this.loadingState = false;
          if (data.success) {
            this.$router.push("/usuario/login");
          } else {
            this.hint = "Código incorreto, tente seu cadastro novamente";
          }
        });
    },
  },
};
</script>
