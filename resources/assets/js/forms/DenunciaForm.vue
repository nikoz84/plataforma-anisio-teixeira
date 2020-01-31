<template>
  <article>
    <div class="row q-pa-md">
      <q-card class="offset-md-3 col-md-6">
        <q-card-section>
          <div class="text-center text-h5" v-text="title"></div>
          <q-separator inset/>
          <p class="q-pt-lg">Este espaço serve para você denunciar qualquer coisa que você considere <b>imprópria</b>,
            basta fornecer o endereço da página onde esse conteúdo se localiza e uma mensagem
            descrevendo do que se trata e por que você acha que essa página merece a denuncia.
          </p>
          <q-separator inset/>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="denunciaForm">
            <q-input filled v-model="name" label="Seu Nome *" hint="Nome" 
                    bottom-slots :error="errors.name && errors.name.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.name"></ShowErrors>
              </template>
            </q-input>
            <q-input v-model="email" label="example@dominio.com *" filled type="email" hint="E-mail"
                    bottom-slots :error="errors.email && errors.email.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.email"></ShowErrors>
              </template>
            </q-input>
            <q-input filled v-model="subject" label="Assunto da mensagem *" hint="Assunto" 
                    bottom-slots :error="errors.subject && errors.subject.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.subject"></ShowErrors>
              </template>
            </q-input>

            <q-input v-model="message" filled type="textarea" label="Escreva aqui sua mensagem *" hint="Mensagem"
                    bottom-slots :error="errors.message && errors.message.length > 0">
              <template v-slot:error>
                <ShowErrors :errors="errors.message"></ShowErrors>
              </template>
            </q-input>
            <div>
              <p>Código de segurança:</p>
              <div class="g-recaptcha" :data-sitekey="siteKey"></div>
              <div bottom-slots :error="errors.recaptcha && errors.recaptcha > 0">
                <ShowErrors :errors="errors.recaptcha"></ShowErrors>
              </div>
            </div>
            
            <div>
              <q-btn class="full-width q-mt-lg" label="Enviar" type="submit" color="primary"/>
            </div>
          </q-form>
        </q-card-section> 
      </q-card>
    </div>
  </article>
</template>

<script>
import ShowErrors from "../components/ShowErrors.vue";
import { mapState, mapMutations } from "vuex";
import { QCard, QCardSection, QImg, QForm, QInput, QSeparator } from "quasar";

export default {
  name: "DenunciaForm",
  components: {
    ShowErrors,
    QCard,
    QCardSection,
    QForm,
    QInput,
    QImg,
    QSeparator
  },
  data() {
    return {
      name: "",
      email: "",
      url: this.$route.params.url,
      subject: "",
      message: "",
      r_id: 0,
      siteKey: "6LczPtQUAAAAAOcgJ9NP9GXPJmA98rppQbsmzuX5"
    };
  },
  beforeRouteEnter(to, from, next) {
    localStorage.setItem("urlDenuncia", `${location.origin}${from.path}`);
    next();
  },
  mounted() {
    if (window.grecaptcha) {
      let container = document.getElementsByClassName("g-recaptcha")[0];
      if (typeof grecaptcha.render === "function") {
        this.r_id = grecaptcha.render(container, {
          sitekey: this.siteKey
        });
      }
    }
  },
  computed: {
    ...mapState(["errors"]),
    getUrl() {
      return localStorage.urlDenuncia;
    },
    title() {
      return this.$route.params.action == "faleconosco"
        ? "Fale Conosco"
        : "Denunciar";
    }
  },
  methods: {
    ...mapMutations(["SET_ERRORS", "SET_IS_ERROR"]),
    async onSubmit() {
      this.$q.loading.show();

      let data = {
        name: this.name,
        email: this.email,
        url: localStorage.urlDenuncia,
        subject: this.subject,
        message: this.message,
        action: this.$route.params.action,
        recaptcha: grecaptcha.getResponse()
      };

      let url = this.$route.params.action;
      let resp = await axios.post(url, data);
      if (resp.data.success && resp.status == 200) {
        this.$q.loading.hide();
        this.SET_ERRORS([]);
        localStorage.removeItem("urlDenuncia");
        this.$router.push("/");
        this.$q.notify({
          color: "positive",
          textColor: "white",
          icon: "done",
          message: "Enviado com sucesso!"
        });
      } else {
        this.SET_ERRORS(resp.data.errors);
        grecaptcha.reset();
        this.$q.loading.hide();
        this.$q.notify({
          color: "negative",
          textColor: "white",
          icon: "error",
          message: "Prencha os campos."
        });
      }
    }
  }
};
</script>
<style lang="stylus" scoped>
</style>
