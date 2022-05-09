<template>
<article class="q-pa-md">
    <div class="row no-wrap justify-center">
        <q-card style="min-width:350px;">
            <q-card-section >
                <div class="text-center text-h5">Mudar Senha</div>
                <div>{{ message }}</div>
            </q-card-section>
            <q-separator inset />
            <q-card-section>
                <q-form @submit.prevent="onSubmit()" class="q-gutter-md" ref="loginForm">
                  <q-input v-model="password" filled :type="isPwd ? 'password' : 'text'" 
                        hint="Senha"
                            bottom-slots 
                            :error="false"
                            >
                    <template v-slot:append>
                      <q-icon
                        :name="isPwd ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd = !isPwd"
                      />
                    </template>
                    <!--template v-slot:error>
                      <ShowErrors :errors="errors.password"></ShowErrors>
                    </!--template-->
                  </q-input>
                  <q-input v-model="confirmation" filled type="password" hint="Repita a senha"
                           :rules="[passwordConfirmationRule]"
                            bottom-slots 
                            :error="false">
                    <!--template v-slot:error>
                      <ShowErrors :errors="errors.confirmation"></ShowErrors>
                    </!--template-->
                  </q-input>
                   <div>
                     <q-btn class="full-width" label="Enviar" type="submit" color="primary"/>
                   </div>
                </q-form>
                
            </q-card-section>
        </q-card>
    </div>
  </article>
</template>
<script>
export default {
    name: "MudarSenhaForm",
    data(){
        return {
            isPwd: false,
            confirmation: false,
            passwordConfirmationRule:false,
            password: null,
            message: null
        }
    }

}
</script>