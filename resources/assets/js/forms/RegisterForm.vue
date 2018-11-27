<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
            <form v-on:submit.prevent="registerUser()">
                
                <div class="panel panel-default col-md-7">
                    <div class="panel-heading">
                        Crie uma conta
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nome do usuário" v-model="name">
                            <small class="form-text text-muted">Escreva seu nome</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" aria-describedby="seu email" v-model="email">
                            <small class="form-text text-muted">Escreva seu e-mail</small>
                        </div>
                        <!-- Nova senha -->
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" aria-describedby="senha" v-model="password">
                            <small class="form-text text-muted">Escreva uma senha</small>
                        </div>
                        <div class="form-group">
                            <label for="confirmasenha">Repita a Senha</label>
                            <input type="password" class="form-control" id="confirmasenha" aria-describedby="confirmar senha" v-model="confirmPassword">
                            <small class="form-text text-muted">Confirmar senha</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Http from '../http.js';

const http = new Http();

export default {
    name: 'RegisterForm',
    components: {},
    data(){
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: ''
        }

    },
    computed:{
        //
    },
    mounted(){
        //
    },
    methods:{
        async registerUser(){
            
            let data = {
                password: this.password,
                name: this.name,
                email: this.email
            };
            
            if(this.password === this.confirmPassword && this.password != ''){
                let resp = await http.postData('/auth/register', data);
                console.log(resp);
            }
        }
    }

}
</script>