<template>
    <div class="conteiner">

        <form>
            <p>Este espaço serve para você informar quaisquer dificuldade ocorrida na
                visualização do conteúdo. Tem alguma dúvida, sugestão ou crítica a fazer?
                Então entre em contato com a gente. Sua opinião é fundamental para o nosso
                aperfeiçoamento.</p>

            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" v-model="name" placeholder="Digite seu nome">
            </div>

            <div class="form-group">
                <label for="email">E-mail:*</label>
                <input type="email" class="form-control" id="email" v-model="email" placeholder="Digite seu e-mail">
            </div>

            <div class="form-group">
                <label for="assunto">Assunto:*</label>
                <input type="text" class="form-control" id="assunto" v-model="subject" placeholder="Qual é o assunto do contato">
            </div>

            <div class="form-group">
                <label for="mensagem">Mensagem:*</label>
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
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>
<script>
import Http from '../http.js';

const http = new Http();
export default {
  data () {
    return {
      name: '',
      email: '',
      url: this.$route.params.url,
      subject: '',
      message: ''
    }
  },
  computed:{
      getUrl(){
          return this.$route.params.url;
      }
  },
  methods:{
    async enviar(){
      let data = { name: this.name, email: this.email,
                    url: this.url, subject: this.subject, message: this.message
        };
      let resp = await http.config('POST','/faleconosco/enviar', data);
      if(resp.data.success){
          this.$router.push('/');
      }

    }
  }
}
</script>
<style lang="scss" scoped>
form { margin-top: 30px; margin-bottom: 30px;}
</style>
