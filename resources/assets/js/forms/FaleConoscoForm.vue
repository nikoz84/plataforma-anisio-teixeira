<template>
    <div class="conteiner">
        <div class="row col-md-7">
            <form v-on:submit.prevent="enviar()" v-if="!isSend">
            <p>Este espaço serve para você informar quaisquer dificuldade ocorrida na
                visualização do conteúdo. Tem alguma dúvida, sugestão ou crítica a fazer?
                Então entre em contato com a gente. Sua opinião é fundamental para o nosso
                aperfeiçoamento.</p>

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

            <div class="form-group">
                <label for="email">E-mail:<span class="glyphicon-asterisk"></span></label>
                <input type="email" class="form-control" id="email" v-model="email" placeholder="Digite seu e-mail">
            </div>

            <div class="form-group">
                <label for="assunto">Assunto:<span class="glyphicon-asterisk"></span></label>
                <input type="text" class="form-control" id="assunto" v-model="subject" placeholder="Qual é o assunto do contato">
            </div>

            <div class="form-group">
                <label for="mensagem">Mensagem:<span class="glyphicon-asterisk"></span></label>
                <textarea class="form-control" id="mensagem" v-model="message" placeholder="Digite aqui sua mensagem"></textarea>
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" v-model="getUrl" disabled>
            </div>

            <p>Este espaço serve para você informar quaisquer dificuldade ocorrida na
                visualização do conteúdo. Tem alguma dúvida, sugestão ou crítica a fazer?
                Então entre em contato com a gente. Sua opinião é fundamental para o nosso
                aperfeiçoamento.</p>

            <div class="form-group">
                <label for="mensagem">Código de segurança:<span class="glyphicon-asterisk"></span></label>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                       <div class="g-recaptcha" :data-sitekey="siteKey"></div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

            </form>
            <div v-else-if="isSend">
                mensagem enviada com sucesso!!
            </div>
            <div class="col-md-12" v-if="isLoading">
                <div class="col-md-1"><Loader></Loader></div>
                <div class="col-md-4">enviando mensagem...</div>
            </div>
        </div>
    </div>
</template>
<script>
import Loader from '../components/LoaderComponent.vue';
import client from '../client.js';


export default {
    name: 'FaleConoscoForm',
    components: { Loader },
    data () {
        return {
        name: '',
        email: '',
        url: this.$route.params.url,
        subject: '',
        message: '',
        isSend: false,
        isLoading: false,
        r_id: 0,
        siteKey: '6LegZ48UAAAAAI-sKAY09kHtR-uBkiizT6XKcOli',
        isError: true,
            success: false,
            errors: {
                name: [],
                email: [],
                url: [],
                subject: [],
                message: [],
                recaptcha: []
            },
    }
  },
  mounted(){
      //console.log(window.grecaptcha)
      if(window.grecaptcha){
          let container = document.getElementsByClassName('g-recaptcha')[0];
          this.r_id = grecaptcha.render(container, { sitekey: this.siteKey })
      }
  },
  computed:{
      getUrl(){
          return this.$route.params.url;
      }
  },
  methods:{
    async enviar(){
      this.isLoading = true;
      let resRecaptcha = grecaptcha.getResponse();
      let data = { name: this.name, email: this.email,
                    url: this.url, subject: this.subject, message: this.message
        };

      let resp = await http.config('POST','/faleconosco/enviar', data);
      this.isSend = resp.data.success;

      if(resp.data.success){
            this.isLoading = false;
      }else{
            this.isLoading = false;
            this.isError = resp.data.success;
            if(resp.data.errors){
                this.errors = resp.data.errors;
            }
      }

      setTimeout(()=>{
            this.isError = true;
        },3000)

    }
  }
}
</script>
<style lang="scss" scoped>
form { margin-top: 30px; margin-bottom: 30px;}

textarea {
  height: 170px;
  resize: none;
}
</style>
