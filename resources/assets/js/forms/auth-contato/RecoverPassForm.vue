<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Recuperar Senha</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-input filled label="Escreva seu e-mail" v-model="email" type="email"></q-input>
            </q-card-section>
            <q-card-section>
                <RecaptchaForm :errors="errors"></RecaptchaForm>
            </q-card-section>
            <q-card-section>
                <q-btn color="primary" 
                    class="full-width" 
                    @click="send()"
                    label="Enviar" ></q-btn>
            </q-card-section>
        </q-card>
    </div>
  </article>
</template>

<script>
import RecaptchaForm from "../RecaptchaForm";

export default {
    name : "RecoverPassForm",
    components:{RecaptchaForm},
    data(){
        return {
            email : null,
            errors: []
        }
    },
    methods: {
        async send(){
            let data = {
                email: this.email,
                recaptcha: grecaptcha.getResponse()
            }
            try {
                let resp = await axios.post('/auth/recuperar-senha', data);
                console.log(resp);
            } catch (error) {
                
            }
        }
    },
}
</script>

<style>

</style>