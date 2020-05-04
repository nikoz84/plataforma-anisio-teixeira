<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Mudar Senha</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="loginForm">
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
                  <q-input v-model="confirmation" filled type="password" hint="Repita a senha"
                            bottom-slots :error="errors.confirmation && errors.confirmation.length > 0">
                    <template v-slot:error>
                      <ShowErrors :errors="errors.confirmation"></ShowErrors>
                    </template>
                  </q-input>
                   <div>
                     <q-btn class="full-width" label="Enviar" type="submit" color="primary"/>
                   </div>
                </q-form>
                
            </q-card-section>
        </q-card>
    </div>
  </article>
</template>
<script>
import ShowErrors from "../components/ShowErrors.vue";
import {QCard, QCardSection } from "quasar";

export default {
  name: "MudarPassForm",
  components: {QCard,
  QCardSection},
  data() {
    return {
      isPwd: false,
      password: "",
      email: null,
      confirmation: false,
      verificationCode: "",
      errors:{}
    };
  },
  methods: {
    async onSubmit() {
      let data = {
        password: this.password,
        code: this.verificationCode
      };
      console.warn(data);
    },
    verificationPass() {}
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
  background: url("/storage/conteudos/conteudos-digitais/galeria/11.jpg")
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
