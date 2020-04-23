<template>
<article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Cadastre-se</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="loginForm">
                  <q-input filled v-model="name" label="Seu Nome *" hint="Nome" type="text"
                                bottom-slots :error="errors.name && errors.name.length > 0">
                    <template v-slot:error>
                      <ShowErrors :errors="errors.name"></ShowErrors>
                    </template>
                  </q-input>
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
                  <q-input v-model="confirmation" filled type="password" hint="Repita a senha"
                            bottom-slots :error="errors.confirmation && errors.confirmation.length > 0">
                    <template v-slot:error>
                      <ShowErrors :errors="errors.confirmation"></ShowErrors>
                    </template>
                  </q-input>
                   <div>
                     <q-btn class="full-width" label="Cadastre-se" type="submit" color="primary"/>
                   </div>
                </q-form>
                
            </q-card-section>
            <q-card-actions align="around">
              <q-btn flat to="/usuario/login">Login</q-btn>
              <q-btn flat to="/usuario/recuperar-senha">Recuperar senha</q-btn>
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
  QSeparator
} from "quasar";

export default {
  name: "RegisterForm",
  components: {
    QCard,
    QCardSection,
    QCardActions,
    QInput,
    QForm,
    QImg,
    QSeparator,
    ShowErrors
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmation: "",
      isPwd: true,
      errors: {}
    };
  },
  methods: {
    async onSubmit() {
      this.$q.loading.show();
      this.errors = {};
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        confirmation: this.confirmation
      };

      try {
        let resp = await axios.post("/auth/cadastro", data);
        this.$q.loading.hide();
        this.$router.push("/usuario/confirmar-email");
      } catch (response) {
        this.errors = response.errors;
        
      }
    }
  }
};
</script>
<style lang="scss" scoped>
</style>
