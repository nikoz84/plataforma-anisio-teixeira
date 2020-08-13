<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Mudar Senha</div>
                <div>{{ message }}</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="loginForm">
                  <q-input v-model="password" filled :type="isPwd ? 'password' : 'text'" hint="Senha"
                            bottom-slots 
                            :error="errors && errors.password && errors.password.length > 0"
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
                  <q-input v-model="confirmation" filled type="password" hint="Repita a senha"
                           :rules="[passwordConfirmationRule]"
                            bottom-slots 
                            :error="errors && errors.confirmation && errors.confirmation.length > 0">
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
import { ShowErrors } from "@forms/shared";
import {QCard, QCardSection } from "quasar";

export default {
  name: "MudarPassForm",
  components: {
    QCard,
    QCardSection,
    ShowErrors
  },
  data() {
    return {
      isPwd: false,
      password: "",
      email: null,
      confirmation: false,
      verificationCode: "",
      errors:{},
      message: ''
    };
  },
   mounted() {
     this.validaToken();
  },
  computed: {
    
    passwordConfirmationRule() {
        return () => (this.password === this.confirmation) || 'Senhas devem combinar'
    }
  },
  methods: {
    async onSubmit() 
    {
      const form = new FormData();
      form.append("password", this.password);
      form.append("confirmation", this.confirmation);
        try {
          let {data} = await axios.post('/auth/modificar-senha/'+this.$route.params.token, form);
          if(data.success){
            this.$router.push(`/usuario/login`);
          }
        } catch(ex) {
           this.errors = ex.errors;
        }
    },

    async validaToken()
    {
        try {
            let {data} = await axios.get('/auth/verificar/'+this.$route.params.token);
        } catch(ex) {
            this.errors = ex.errors;
            this.$router.push(`/usuario/login`);
        }
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
