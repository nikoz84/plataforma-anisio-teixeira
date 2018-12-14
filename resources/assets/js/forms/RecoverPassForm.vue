<template>
    <div class="row">
      <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
            <form v-on:submit.prevent="recoverPass()">
                
                <div class="panel panel-default col-md-7">
                    <div class="panel-heading">
                        Mudar Senha
                    </div>
                    <div class="panel-body">
                        <!-- Nova senha -->
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" aria-describedby="senha" v-model="password">
                            <small class="form-text text-muted">Escreva uma nova senha</small>
                        </div>
                        <div class="form-group">
                            <label for="confirmasenha">Repita a Senha</label>
                            <input type="password" class="form-control" id="confirmasenha" aria-describedby="confirmar senha" v-model="confirmPassword">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default">Enviar</button>
                    </div>
                    <router-link to="/usuario/login">
                        Login 
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Http from '../http.js';


export default {
    name: 'RecoverForm',
    components: {},
    data(){
        return {
            password: '',
            confirmPassword: '',
            verificationCode: ''
        }

    },
    created(){
        
    },
    methods:{
        async recoverPass(){
            
            let data = {
                password: this.password,
                code: this.verificationCode
            };
            console.warn(data);
            //let http = new Http();
            //let resp = await http.postData('/conteudos/', data);

        },
        verificationPass(){
            
        }
    }

}
</script>