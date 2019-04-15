<template>
    <div class="conteiner">
        <div class="row col-lg-6 col-xs-offset-3">

        <h2><legend>Adicionar Usuário</legend></h2>

        <form v-on:submit.prevent="send()">

            <div class="form-group" v-bind:class="{ 'has-error': errors.email && errors.email.length > 0 }">
                <label for="login">Login:*</label>
                <input type="email" class="form-control" id="login" v-model="email" aria-describedby="login_usuario" placeholder="Digite o login de usuário">
                <small id="login_usuario" class="form-text text-muted">Pode utilizar uma conta de e-mail como login (exemplo: aew.usuario@gmail.com, aew.usuario@hotmail.com)</small><br>
                <small class="text-danger"
                        v-if="errors.email"
                        v-for="(error,e) in errors.email"
                        v-bind:key="e"
                        v-text="error">
                </small>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" v-model="name" placeholder="Digite o completo do usuário">
                <small class="text-danger"
                        v-if="errors.name"
                        v-for="(error,n) in errors.name"
                        v-bind:key="n"
                        v-text="error">
                </small>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': errors.role && errors.role.length > 0 }">
                <label for="tipo">Tipo usuário:*</label>
                <select class="form-control" id="tipousuario" v-model="role">
                <option value=""> SELECIONE </option>
                <option value="super administrador">super administrador</option>
                <option value="administrador">administrador</option>
                <option value="coordenador">coordenador</option>
                <option value="editor">editor</option>
                <option value="colaborador">colaborador</option>
                </select>
                <small class="text-danger"
                        v-if="errors.role"
                        v-for="(error,r) in errors.role"
                        v-bind:key="r"
                        v-text="error">
                </small>
            </div>
            <legend>Marque o(s) canais ao qual pertence o usuário:</legend>
            <div class="form-check">
                <input class="form-check-input" v-model="ambiente_ensino" name="ambiente_ensino" type="checkbox" value="" id="ambiente_ensino">
                <label class="form-check-label" for="ambiente_ensino">
                    Ambiente de Ensino a Aprendizagem Colaborativa
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="aplicativo_educacionais" type="checkbox" value="" id="aplicativo_educacionais">
                <label class="form-check-label" for="aplicativo_educacionais">
                    Aplicativos Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="blogrede" type="checkbox" value="" id="blogrede">
                <label class="form-check-label" for="blogrede">
                    Blog da Rede
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="emitec" type="checkbox" value="" id="emitec">
                <label class="form-check-label" for="emitec">
                    EMITEC - Ensino Médio com Intermediação Tecnológica
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="midias_educacionais" type="checkbox" value="" id="midias_educacionais">
                <label class="form-check-label" for="midias_educacionais">
                    Mídias Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="projetos_artisticos" type="checkbox" value="" id="projetos_artisticos">
                <label class="form-check-label" for="projetos_artisticos">
                    Projetos Artísticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="radioat" type="checkbox" value="" id="radioat">
                <label class="form-check-label" for="radioat">
                    Rádio Anísio Teixeira
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="sites_tematicos" type="checkbox" value="" id="sites_tematicos">
                <label class="form-check-label" for="sites_tematicos">
                    Sites Temáticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="tvat" type="checkbox" value="" id="tvat">
                <label class="form-check-label" for="tvat">
                    Tv Anísio Teixeira
                </label>
            </div>
            <div class="form-group">
                <label class="form-check-label" for="sexo">
                Sexo:
                </label>
                <label>
                <input class="form-check-input" type="radio" name="sexo" id="sexo-m" value="m" checked>
                Masculino
                </label>
                <label>
                <input class="form-check-input" type="radio" name="sexo" id="sexo-f" value="f">
                Feminino
                </label>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.birthday && errors.birthday.length > 0 }">
                <label for="databirthday">Data de birthday:</label>
                <input type="date" class="form-control" id="databirthday" name="databirthday" v-model="birthday">
                <small class="text-danger"
                        v-if="errors.birthday"
                        v-for="(error,day) in errors.birthday"
                        v-bind:key="day"
                        v-text="error">
                </small>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.password && errors.password.length > 0 }">
                <label for="senha">Senha:*</label>
                <input type="password" class="form-control" id="senha" name="senha" v-model="password">
                <small class="text-danger"
                        v-if="errors.password"
                        v-for="(error,pass) in errors.password"
                        v-bind:key="pass"
                        v-text="error">
                </small>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.password_confirmation && errors.password_confirmation.length > 0 }">
                <label for="confirmation">Confirmar Senha:*</label>
                <input type="password" class="form-control" id="confirmation" name="confirmation" v-model="password_confirmation">
                <small class="text-danger"
                        v-if="errors.password_confirmation"
                        v-for="(error,pass_c) in errors.password_confirmation"
                        v-bind:key="pass_c"
                        v-text="error">
                </small>
            </div>    
            <!--<div class="form-group" v-bind:class="{ 'has-error': errors.emailinstitucional && errors.emailinstitucional.length > 0 }">
                <label for="emailinstitucional">E-mail Institucional:*</label>
                <input type="email" class="form-control" id="emailinstitucional" name="emailinstitucional" v-model="emailinstitucional">
                <small class="text-danger"
                        v-if="errors.emailinstitucional"
                        v-for="(error,ei) in errors.emailinstitucional"
                        v-bind:key="ei"
                        v-text="error">
                </small>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.emailpessoal && errors.emailpessoal.length > 0 }">
                <label for="emailpessoal">E-mail Pessoal:*</label>
                <input type="email" class="form-control" id="emailpessoal" name="emailpessoal" v-model="emailpessoal">
                <small class="text-danger"
                        v-if="errors.emailpessoal"
                        v-for="(error,ep) in errors.emailpessoal"
                        v-bind:key="ep"
                        v-text="error">
                </small>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.password && errors.password.length > 0 }">
                <label for="cpf">Senha:*</label>
                <input type="password" class="form-control" id="senha" name="senha" v-model="password">
                <small class="text-danger"
                        v-if="errors.password"
                        v-for="(error,pass) in errors.password"
                        v-bind:key="pass"
                        v-text="error">
                </small>
            </div>
            <div class="form-group">
                <label for="cpf">RG:</label>
                <input type="text" class="form-control" id="rg" name="rg">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco">
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" class="form-control" id="numero" name="numero">
            </div>
            <div class="form-group">
                <label for="complemento">complemento:</label>
                <input type="text" class="form-control" id="complemento" name="complemento ">
            </div>
            <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control form-control-lg" id="estado">
            </select>
            </div>
            <div class="form-group">
                <label for="municipio">Município:</label>
                <select class="form-control form-control-lg" id="municipio">
                </select>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" id="bairro" name="bairro">
            </div>
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" class="form-control" id="cep" name="cep">
            </div>
            <div class="form-group">
                <label for="escola">Escola:</label>
                <select class="form-control form-control-lg" id="escola">
                    <option value="">« SELECIONE »</option>
                </select>
            </div>-->
            <transition  name="custom-classes-transition"
                enter-active-class="animated shake"
                leave-active-class="animated fadeOut">
                <div v-if="!isError" class="alert alert-info" role="alert" >
                    {{ message }}
                </div>
            </transition>

            <button class="btn btn-success">{{ textButton }}</button>

        </form>

    </div>
    </div>
</template>

<script>
import client from '../client.js';

export default {
    name: 'UsuarioForm',

    data(){
        return {
            name: '',
            email: '',
            role: '',
            ambiente_ensino: '',
            aplicativo_educacionais: '',
            blogrede: '',
            emitec: '',
            midias_educacionais: '',
            projetos_artisticos: '',
            radioat: '',
            sites_tematicos: '',
            tvat: '',
            birthday: '',
            password: '',
            password_confirmation: '',
            options: {},
            message: null,
            success: false,
            isError: true,
            isUpdate: false,
            textButton: 'Criar',
            errors: {
                email:[],
                name:[],
                role:[],
                birthday:[]
            },
        }

    },

    created(){
        if(this.$route.params.update){
            this.getUsuario();
            this.isUpdate = true;
            this.textButton = 'Editar';
        }
    },
    methods:{
        send(){
            if(this.isUpdate){
                this.editUsuario();
            }else{
                this.createUsuario();
            }
        },
        async createUsuario(){
            this.options= {
                'role': this.role,
                'birthday': this.birthday
            };
            let form = new FormData();
            form.append('email', this.email);
            form.append('name',this.name);
            form.append('role',this.role);
            form.append('birthday',this.birthday);
            form.append('password',this.password);
            form.append('password_confirmation',this.password_confirmation);
            form.append('is_featured', this.is_featured);
            form.append('options', JSON.stringify(this.options));
            form.append('token', localStorage.token);

            let resp = await client.post(`/users`, form);
            console.warn(resp);

            if(resp.data.success){
                this.message = resp.data.message;
            }else{
                this.isError = resp.data.success;
                this.message = resp.data.message;
                if(resp.data.errors){
                    this.errors = resp.data.errors;
                }

                setTimeout(()=>{
                    this.isError = true;
                },3000)
            }

        },

        async getUsuario(){
            let params = {token: localStorage.token };
            let resp = await client.get(`/users/${this.$route.params.id}`,{params});
            //console.warn(resp.data)
            if(resp.data.success){
                let user = resp.data.user;
                //console.log(user)
                this.name = user.name;
                this.email = user.email;
                this.role = user.options.role;
                this.birthday = user.options.birthday;

            }
        },

        async editUsuario(){

            let params ={
                name: this.name,
                email: this.email
            }

            let resp = await client.put(`/users/${this.$route.params.id}`,params);

            console.log(resp)
        }

    }

}
</script>