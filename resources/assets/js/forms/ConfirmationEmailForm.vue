<template>
    <article class="q-pa-md">
        <div class="row no-wrap justify-center">
            <q-card class="col-sm-6">
                <q-card-section>
                    <div class="text-center text-h5">
                    Verificar Email
                    </div>
                </q-card-section>
                <q-card-section>
                    <q-input v-model="token" :loading="loadingState"></q-input>
                </q-card-section>
                <q-card-actions align="around">
                    <q-btn color="primary" flat @click="verify" label="Verificar"></q-btn>
                </q-card-actions>
            </q-card>
        </div>
    </article>
</template>
<script>
import { QCard, QCardSection, QCardActions, QBtn, QInput } from 'quasar';

export default {
    name:"ConfirmationEmailForm",
    components: { QCard, QCardSection, QCardActions, QBtn, QInput },
    data(){
        return {
            token: null,
            loadingState : false,
            errors: {}
        }
    },
    methods: {
        async verify() {
            if (!this.token) return;
            this.loadingState = true
            try {
                let resp = await axios.post(`/auth/verificar/${this.token}`);
                    this.loadingState = false;
                    console.log(resp)
                
            } catch (response) {
                this.errors = response.errors;
                this.loadingState = false;
            }
                
        }
    }
}
</script>