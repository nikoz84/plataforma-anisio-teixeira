<template>
  <article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Recuperar Senha</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-input filled 
                    label="Escreva seu e-mail" 
                    v-model="email" 
                    type="email"
                    :error="errors.email && errors.email.length > 0"
                    bottom-slots>
                    <template v-slot:error>
                        <ShowErrors :errors="errors.email"></ShowErrors>
                    </template>
                </q-input>
            </q-card-section>
            <q-card-section>
                <RecaptchaForm :errors="errors.recaptcha"></RecaptchaForm>
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
import { RecaptchaForm, ShowErrors } from "@forms/shared";

export default {
    name : "RecoverPassForm",
    components:{RecaptchaForm, ShowErrors},
    data(){
        return {
            email : null,
            errors: []
        }
    },
    methods: {
        async send(){
            const form = new FormData();
            form.append("email", this.email);
            form.append("recaptcha",grecaptcha.getResponse());
            try 
            {
                let {data} = await axios.post('/auth/recuperar-senha', form);
                this.$router.push(`/usuario/login`);
                if(data.success){
                    console.log(data)
                }
            } catch (e) {
                console.log(e);
                this.errors = e.errors;

            }
        }
    },
}
</script>

<style>

</style>