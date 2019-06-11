<template>
<div class="bg-img">
      <div class="row">
        <div class="col-md-6 foto">
          <a href="/galeria" class="gallery-link">Visite nossa galeria de fotos</a>
        </div>
        <form v-on:submit.prevent="send()">
        <article class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <button class="btn btn-default col-md-6" v-if="!isLoading">Enviar</button>
              <div v-else>
                <Loader></Loader>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="panel-body">
        
          <div class="col-md-6">
            <h4 class="text-center">
              Denuncie
            </h4>
            <p>Este espaço serve para você denunciar qualquer coisa que você considere imprópria,
               basta fornecer o endereço da página onde esse conteúdo se localiza e uma mensagem
               descrevendo do que se trata e por que você acha que essa página merece a denuncia.

            </p>

            <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                <label for="nome">Nome:<span class="glyphicon-asterisk"></span></label>
                <input type="text" class="form-control" id="nome" v-model="name" placeholder="Digite seu nome">
                <ShowErrors :errors="errors.name"></ShowErrors>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.email && errors.email.length > 0 }">
                <label for="email">E-mail:<span class="glyphicon-asterisk"></span></label>
                <input type="email" 
                      class="form-control" 
                      id="email" 
                      v-model="email" 
                      placeholder="Digite seu e-mail"
                      autocomplete="off">
                <ShowErrors :errors="errors.email"></ShowErrors>
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" v-model="getUrl" disabled>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" v-bind:class="{ 'has-error': errors.subject && errors.subject.length > 0 }">
                <label for="assunto">Assunto:<span class="glyphicon-asterisk"></span></label>
                <input type="text" class="form-control" id="assunto" v-model="subject" placeholder="Qual é o assunto do contato">
                <ShowErrors :errors="errors.subject"></ShowErrors>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.message && errors.message.length > 0 }">
                <label for="mensagem">Mensagem:<span class="glyphicon-asterisk"></span></label>
                <textarea class="form-control" id="mensagem" v-model="message" placeholder="Digite aqui sua mensagem"></textarea>
                <ShowErrors :errors="errors.message"></ShowErrors>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.recaptcha && errors.recaptcha.length > 0 }">
                <label for="mensagem">Código de segurança:<span class="glyphicon-asterisk"></span></label>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                       <div class="g-recaptcha" :data-sitekey="siteKey"></div>
                       <small class="text-danger"
                            v-if="errors.recaptcha"
                            v-for="(error,r) in errors.recaptcha"
                            v-bind:key="r"
                            v-text="error">
                        </small>
                        <ShowErrors :errors="errors.recaptcha"></ShowErrors>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </article>
    </form>
  </div>
</div>
</template>

<script>
import Loader from "../components/Loader.vue";
import ShowErrors from "../components/ShowErrors.vue";
import { mapState, mapMutations } from "vuex";

export default {
  name: "DenunciaForm",
  components: { Loader, ShowErrors },
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
    ...mapState(["errors", "isLoading", "isError"]),

    getUrl() {
      return localStorage.urlDenuncia;
    }
  },
  methods: {
    ...mapMutations(["SET_IS_LOADING", "SET_ERRORS", "SET_IS_ERROR"]),
    async send() {
      this.SET_IS_LOADING(true);

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

      if (resp.data.success && res.status == 200) {
        this.SET_IS_LOADING(false);
        localStorage.removeItem("urlDenuncia");
      } else {
        this.SET_ERRORS(resp.data.errors);
        this.SET_IS_ERROR(true);
        this.SET_IS_LOADING(false);
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.panel {
  padding-bottom: 60px;
}

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
