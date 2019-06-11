<template>
    
  <div class="row">
      <div class="col-md-6 foto">
          <!--<img class="img-responsive" src="/storage/conteudos/conteudos-digitais/galeria/10.jpg" alt="">-->
      </div>
      <article class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                
            </div>
            <div class="panel-body">
                <form v-on:submit.prevent="enviar()">
                  <div class="col-md-6">
                    <h4 class="panel-title text-center">Fale Conosco</h4>
                      <p>Este espaço serve para você informar quaisquer dificuldade ocorrida na
                          visualização do conteúdo. Tem alguma dúvida, sugestão ou crítica a fazer?
                          Então entre em contato com a gente. Sua opinião é fundamental para o nosso
                          aperfeiçoamento.</p>

                      <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                          <label for="nome">Nome:<span class="glyphicon-asterisk"></span></label>
                          <input type="text" class="form-control" id="nome" v-model="data.name" placeholder="Digite seu nome">
                          <small class="text-danger"
                                  v-if="errors.name"
                                  v-for="(error,n) in errors.name"
                                  v-bind:key="n"
                                  v-text="error">
                          </small>
                      </div>

                      <div class="form-group">
                          <label for="email">E-mail:<span class="glyphicon-asterisk"></span></label>
                          <input type="email" class="form-control" id="email" v-model="data.email" placeholder="Digite seu e-mail">
                      </div>

                      <div class="form-group">
                          <label for="assunto">Assunto:<span class="glyphicon-asterisk"></span></label>
                          <input type="text" class="form-control" id="assunto" v-model="data.subject" placeholder="Qual é o assunto do contato">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="mensagem">Mensagem:<span class="glyphicon-asterisk"></span></label>
                          <textarea class="form-control" id="mensagem" v-model="data.message" placeholder="Digite aqui sua mensagem"></textarea>
                      </div>

                      <div class="form-group">
                          <label for="mensagem">Código de segurança:<span class="glyphicon-asterisk"></span></label>
                          
                            <div class="g-recaptcha" :data-sitekey="siteKey"></div>
                      </div>

                      <div class="form-group">
                          <button class="btn btn-default">Enviar</button>
                      </div>
                    </div>  
                </form>
            </div>
        </div>
      </article>
  </div>
</template>
<script>
import Loader from "../components/Loader.vue";

export default {
  name: "FaleConoscoForm",
  components: { Loader },
  data() {
    return {
      data:{ 
        name: "",
        email: "",
        subject: "",
        message: "",
      },
      r_id: 0,
      siteKey: "6LegZ48UAAAAAI-sKAY09kHtR-uBkiizT6XKcOli",
      errors: {
        name: [],
        email: [],
        subject: [],
        message: [],
        recaptcha: []
      }
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
  methods: {
    async enviar() {
      
      let data = {
        name: this.name,
        email: this.email,
        subject: this.subject,
        message: this.message,
        recaptcha: grecaptcha.getResponse()
      };

      let resp = await axios.config("POST", "/faleconosco", data);
      
      console.log(resp);
      
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
  background: url("/storage/conteudos/conteudos-digitais/galeria/4.jpg");
  height: 615px;
}

@media only screen and (max-width: 200px){

  .foto {
  width: auto;
  background: url("/storage/conteudos/conteudos-digitais/galeria/4.jpg");
  }

}
</style>
