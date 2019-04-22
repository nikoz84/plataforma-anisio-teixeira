<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-4 col-xs-10 col-xs-offset-1 center-xs">
            <form v-on:submit.prevent="registerUser()">
                
                <div class="panel panel-default col-md-7">
                    <div class="panel-heading">
                        Crie uma conta
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nome do usuário" v-model="name">
                            <small class="form-text text-muted">Escreva seu nome</small>
                            <small class="text-danger"
                                v-if="errors.name"
                                v-for="(error,n) in errors.name"
                                v-bind:key="n"
                                v-text="error">
                            </small>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': errors.email && errors.email.length > 0 }">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" aria-describedby="seu email" v-model="email">
                            <small class="form-text text-muted">Escreva seu e-mail</small>
                            <small class="text-danger"
                                v-if="errors.email"
                                v-for="(error,e) in errors.email"
                                v-bind:key="e"
                                v-text="error">
                            </small>
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
                        <transition  name="custom-classes-transition" 
                            enter-active-class="animated shake" 
                            leave-active-class="animated fadeOut">
                            <div v-if="!isError" class="alert alert-info" role="alert" >
                                {{ message }}
                            </div>
                        </transition>
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
import client from '../client.js';

export default {
    name: 'RegisterForm',
    components: {},
    data(){
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            isError: true,
            message: '',
            errors: {
                email: [],
                name: [],
                password: []
            }    
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

            let resp = await client.post(`/auth/register`, data);
            
            if(resp.data.success){
                //console.log(resp.data);
                //this.$router.push('listar')
            }else{
                console.warn(resp.data);
                this.isError = resp.data.success;
                this.message = resp.data.message;
                if(resp.data.errors){
                    this.errors = resp.data.errors;
                }
                setTimeout(()=>{
                    this.isError = true;
                },3000)
            }
            
        }
    }

}
</script>