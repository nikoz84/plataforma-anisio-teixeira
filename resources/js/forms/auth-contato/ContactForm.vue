<template>
  <article>
    <div class="row q-pa-md">
      <q-card class="offset-md-3 col-md-6">
        <q-card-section>
          <div class="text-center text-h5" v-text="title"></div>
        </q-card-section>
        <q-card-section>
          <p v-if="$route.params.action == 'denuncia'">
            Denuncie neste espaço, o ODA que você considera imprópio,
            descrevendo a situação.
          </p>
          <p v-if="$route.params.action == 'faleconosco'">
            Perguntas ou dúvidas? por favor preencha o formulario embaixo;
          </p>
          <p v-if="$route.params.action == 'reportar'">
            Reporte algum problema na visualização ou qualquer resultado não
            esperado no site.
          </p>
        </q-card-section>
        <q-card-section>
          <q-form
            @submit.prevent="onSubmit()"
            class="q-gutter-md"
            ref="denunciaForm"
          >
            <q-input
              filled
              v-model="name"
              label="Seu Nome"
              hint="Nome obrigatório"
              bottom-slots
              :error="errors.name && errors.name.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.name"></ShowErrors>
              </template>
            </q-input>
            <q-input
              v-model="email"
              label="example@dominio.com"
              filled
              type="email"
              hint="E-mail obrigatório"
              bottom-slots
              :error="errors.email && errors.email.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.email"></ShowErrors>
              </template>
            </q-input>
            <q-input
              filled
              v-model="subject"
              label="Assunto da mensagem"
              hint="Assunto obrigatório"
              bottom-slots
              :error="errors.subject && errors.subject.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.subject"></ShowErrors>
              </template>
            </q-input>

            <q-input
              v-model="message"
              filled
              type="textarea"
              label="Escreva aqui sua mensagem"
              hint="Mensagem obrigatório"
              bottom-slots
              :error="errors.message && errors.message.length > 0"
            >
              <template v-slot:error>
                <ShowErrors :errors="errors.message"></ShowErrors>
              </template>
            </q-input>

            <RecaptchaForm :errors="errors.recaptcha"></RecaptchaForm>
            <div>
              <q-btn
                class="full-width q-mt-lg"
                label="Enviar"
                type="submit"
                color="primary"
              />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </article>
</template>

<script>
import { RecaptchaForm, ShowErrors } from "@/forms/shared";

export default {
  name: "ContactForm",
  components: {
    ShowErrors,
    RecaptchaForm,
  },
  data() {
    return {
      errors: {},
      name: "",
      email: "",
      url: this.$route.params.url,
      subject: "",
      message: "",
      recaptcha: null,
    };
  },
  beforeRouteEnter(to, from, next) {
    localStorage.setItem("urlDenuncia", `${location.origin}${from.path}`);
    next();
  },

  computed: {
    getUrl() {
      return localStorage.urlDenuncia;
    },
    title() {
      switch (this.$route.params.action) {
        case "faleconosco":
          return "Fale conosco";
          break;
        case "denunciar":
          return "Denunciar Conteúdo";
          break;
        case "reportar":
          return "Reportar Problema";
          break;
        case "sugestao":
          return "Sugestão de Conteúdo";
          break;
        default:
          return "Outros";
          break;
      }
    },
  },
  methods: {
    async onSubmit() {
      this.$q.loading.show();

      let data = {
        name: this.name,
        email: this.email,
        url: localStorage.urlDenuncia,
        subject: this.subject,
        message: this.message,
        action: this.$route.params.action,
        recaptcha: grecaptcha.getResponse(),
      };

      try {
        let resp = await axios.post("/contato", data);
        this.$q.loading.hide();
        this.errors = {};
        localStorage.removeItem("urlDenuncia");
        this.$router.push("/");
      } catch (response) {
        this.errors = response.errors;
        grecaptcha.reset();
      }
    },
  },
};
</script>
<style lang="stylus" scoped></style>
