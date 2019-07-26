<template>
<article>
     <IntroParallax/>
    <div class="row">
        <q-card class="offset-md-4 col-md-4">
            <q-card-section >
                <div class="text-center text-h5">Cadastrese</div>
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
                  <q-input v-model="confirmation" filled type="password" hint="Senha"
                            bottom-slots :error="errors.confirmation && errors.confirmation.length > 0">
                    <template v-slot:error>
                      <ShowErrors :errors="errors.confirmation"></ShowErrors>
                    </template>
                  </q-input>
                   <div>
                     <q-btn class="full-width" label="Cadastre-se" type="submit" color="primary"/>
                   </div>
                </q-form>
                
                <div class="text-center q-mt-lg">
                  <router-link to="/usuario/recuperar-senha">
                    Recuperar senha
                  </router-link> |
                  <router-link to="/usuario/login">
                      Login
                  </router-link>
                </div>
            </q-card-section>
        </q-card>
    </div>
  </article>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import ShowErrors from "../components/ShowErrors.vue";
import { QCard, QCardSection, QInput, QForm, QImg, QSeparator } from "quasar";
import IntroParallax from "../components/IntroParallax.vue";

export default {
  name: "RegisterForm",
  components: { QCard,
    QCardSection,
    ShowErrors,
    QForm,
    QInput,
    QImg,
    IntroParallax },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmation: "",
      isPwd: true
    };
  },
  computed: {
    ...mapState(["isError", "errors"])
  },
  mounted() {
    //
  },
  methods: {
    ...mapActions(["registerUser"]),
    ...mapMutations(["SET_ERRORS"]),
    async onSubmit() {
      this.$q.loading.show();
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        confirmation: this.confirmation
      };
      let resp = await axios.post('/auth/register',data);
      
      if(resp.data.success){
        this.$q.loading.hide();
        this.SET_ERRORS([]);
        this.$router.push("/usuario/login");
        
        this.$q.notify({
          color: "positive",
          textColor: "white",
          icon: "done",
          message: `${resp.data.message}`
        });
      }else{
        this.$q.loading.hide();
        this.SET_ERRORS(resp.data.errors);
        
        this.$q.notify({
          color: "negative",
          textColor: "white",
          icon: "error",
          message: resp.data.message
        });
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.form-image {
  display: block;
  min-height: 100vh;
  padding: 0;
  background: url("/storage/conteudos/conteudos-digitais/galeria/5.jpg")
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
