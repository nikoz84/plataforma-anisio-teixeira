<template>
<div class="bg-img">
      <div class="row">
        <div class="col-md-6 foto">
          <!--<img class="img-responsive" src="/storage/conteudos/conteudos-digitais/galeria/10.jpg" alt="">-->
        </div>
        <article class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title text-center">Denúncia</h4>
            </div>
            <div class="panel-body">
        <form v-on:submit.prevent="send()" v-if="!isSend">
          <div class="col-md-6">
            <p>Este espaço serve para você denunciar qualquer coisa que você considere imprópria,
               basta fornecer o endereço da página onde esse conteúdo se localiza e uma mensagem
               descrevendo do que se trata e por que você acha que essa página merece a denuncia.

            </p>

            <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                <label for="nome">Nome:<span class="glyphicon-asterisk"></span></label>
                <input type="text" class="form-control" id="nome" v-model="name" placeholder="Digite seu nome">
                <small class="text-danger"
                        v-if="errors.name"
                        v-for="(error,n) in errors.name"
                        v-bind:key="n"
                        v-text="error">
                </small>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.email && errors.email.length > 0 }">
                <label for="email">E-mail:<span class="glyphicon-asterisk"></span></label>
                <input type="email" 
                      class="form-control" 
                      id="email" 
                      v-model="email" 
                      placeholder="Digite seu e-mail"
                      autocomplete="off">
                <small class="text-danger"
                        v-if="errors.email"
                        v-for="(error,e) in errors.email"
                        v-bind:key="e"
                        v-text="error">
                </small>
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" v-model="getUrl" disabled>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.subject && errors.subject.length > 0 }">
                <label for="assunto">Assunto:<span class="glyphicon-asterisk"></span></label>
                <input type="text" class="form-control" id="assunto" v-model="subject" placeholder="Qual é o assunto do contato">
                <small class="text-danger"
                        v-if="errors.subject"
                        v-for="(error,s) in errors.subject"
                        v-bind:key="s"
                        v-text="error">
                </small>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group" v-bind:class="{ 'has-error': errors.message && errors.message.length > 0 }">
                <label for="mensagem">Mensagem:<span class="glyphicon-asterisk"></span></label>
                <textarea class="form-control" id="mensagem" v-model="message" placeholder="Digite aqui sua mensagem"></textarea>
                <small class="text-danger"
                        v-if="errors.message"
                        v-for="(error,m) in errors.message"
                        v-bind:key="m"
                        v-text="error">
                </small>
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
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button class="btn btn-default" v-if="!isLoading">Enviar</button>
            </div>
          </div>

        </form>
        <div v-else-if="isSend">
            Denúncia enviada com sucesso!!
        </div>
        <div class="col-md-12" v-if="isLoading">
            <div class="col-md-1"><Loader></Loader></div>
            <div class="col-md-4">enviando denúncia...</div>
        </div>
              </div>
            </div>
        </article>
      </div>
</div>
</template>

<script>
import Loader from "../components/Loader.vue";

export default {
  name: "DenunciaForm",
  components: { Loader },
  data() {
    return {
      name: "",
      email: "",
      url: this.$route.params.url,
      subject: "",
      message: "",
      isSend: false,
      isLoading: false,
      r_id: 0,
      siteKey: "6LegZ48UAAAAAI-sKAY09kHtR-uBkiizT6XKcOli",
      isError: true,
      success: false,
      errors: {
        name: [],
        email: [],
        url: [],
        subject: [],
        message: [],
        recaptcha: []
      }
    };
  },
  mounted() {
    //console.log(window.grecaptcha)
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
    getUrl() {
      return localStorage.urlDenuncia;
    }
  },
  methods: {
    async send() {
      this.isLoading = true;

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
      this.isSend = resp.data.success;

      if (resp.data.success) {
        this.isLoading = false;
        localStorage.removeItem("urlDenuncia");
      } else {
        this.isLoading = false;
        this.isError = resp.data.success;
        if (resp.data.errors) {
          this.errors = resp.data.errors;
        }
      }

      setTimeout(() => {
        this.isError = true;
      }, 3000);
    }
  }
};
</script>
<style lang="scss" scoped>
form {
  margin-top: 30px;
  margin-bottom: 30px;
}

textarea {
  height: 170px;
  resize: none;
}

.foto {
  overflow: hidden;
  background: url("/storage/conteudos/conteudos-digitais/galeria/10.jpg");
  height: 615px;
}

@media only screen and (max-width: 200px){

  .foto {
  width: auto;
  background: url("/storage/conteudos/conteudos-digitais/galeria/10.jpg");
  }

}

</style>
