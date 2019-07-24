<template>
  <article class="row">
    <q-card>
      <q-card-section>
        <div class="text-center text-h5">
          Denuncie
        </div>
        <p class="q-pt-lg">Este espaço serve para você denunciar qualquer coisa que você considere <b>imprópria</b>,
          basta fornecer o endereço da página onde esse conteúdo se localiza e uma mensagem
          descrevendo do que se trata e por que você acha que essa página merece a denuncia.
        </p>
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

          <q-input v-model="message" filled type="textarea" 
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
            <q-btn label="Enviar" type="submit" color="primary"/>
          </div>
        </q-form>
      </q-card-section> 
    </q-card>
  </article>
</template>

<script>
import Loader from "../components/Loader.vue";
import ShowErrors from "../components/ShowErrors.vue";
import { mapState, mapMutations } from "vuex";
import { QCard, QCardSection, QImg, QForm, QInput } from "quasar";

export default {
  name: "DenunciaForm",
  components: { Loader, ShowErrors, QCard, QCardSection, QForm, QInput, QImg },
  data() {
    return {
      name: "",
      email: "",
      url: this.$route.params.url,
      subject: "",
      message: "",
      r_id: 0,
      siteKey: "6LegZ48UAAAAAI-sKAY09kHtR-uBkiizT6XKcOli"
    };
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
    ...mapState(["errors", "isLoading", "isError", "viewport"]),

    getUrl() {
      return localStorage.urlDenuncia;
    }
  },
  methods: {
    ...mapMutations(["SET_ERRORS", "SET_IS_ERROR"]),
    async onSubmit(e) {
      this.$q.loading.show();

      let data = {
        name: this.name,
        email: this.email,
        url: localStorage.urlDenuncia,
        subject: this.subject,
        message: this.message,
        action: location.href,
        recaptcha: grecaptcha.getResponse()
      };

      let resp = await axios.post("/denuncias", data);
      if (resp.data.success && resp.status == 200) {
        this.$q.loading.hide();
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
          message: "Ups! Ouve um problema."
        });
      }
    }
  }
};
</script>
<style lang="scss" scoped>
textarea {
  height: 170px;
  resize: none;
}

.foto {
  overflow: hidden;
  background: url("/storage/conteudos/conteudos-digitais/galeria/10.jpg");
  height: 615px;
  opacity: 0.9;
}

@media only screen and (max-width: 200px) {
  .foto {
    width: auto;
    background: url("/storage/conteudos/conteudos-digitais/galeria/10.jpg");
  }
}
.gallery-link {
  position: absolute;
  bottom: 0px;
  right: 0px;
  border-top-left-radius: 10px;
  padding: 15px 30px;
  background-color: #fff;
  -webkit-box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  -moz-box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  color: rgb(4, 9, 30);
  text-transform: uppercase;
  font-size: 11px;
  font-weight: bolder;
  display: inline-block;
  opacity: 0.7;
}
</style>
