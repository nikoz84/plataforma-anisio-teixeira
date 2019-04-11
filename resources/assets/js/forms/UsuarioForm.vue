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
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal1">
                <label class="form-check-label" for="usuarioperfilcanal1">
                    Ambiente de Ensino a Aprendizagem Colaborativa
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal2">
                <label class="form-check-label" for="usuarioperfilcanal2">
                    Aplicativos Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal3">
                <label class="form-check-label" for="usuarioperfilcanal3">
                    Blog da Rede
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal4">
                <label class="form-check-label" for="usuarioperfilcanal4">
                    EMITEC - Ensino Médio com Intermediação Tecnológica
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal5">
                <label class="form-check-label" for="usuarioperfilcanal5">
                    Mídias Educacionais
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal6">
                <label class="form-check-label" for="usuarioperfilcanal6">
                    Projetos Artísticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal7">
                <label class="form-check-label" for="usuarioperfilcanal7">
                    Rádio Anísio Teixeira
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal8">
                <label class="form-check-label" for="usuarioperfilcanal8">
                    Sites Temáticos
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="usuarioperfilcanal[]" type="checkbox" value="" id="usuarioperfilcanal9">
                <label class="form-check-label" for="usuarioperfilcanal9">
                    Tv Anísio Teixeira
                </label>
            </div>
            <div class="form-check">
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
            <div class="form-group" v-bind:class="{ 'has-error': errors.nascimento && errors.nascimento.length > 0 }">
                <label for="datanascimento">Data de nascimento:</label>
                <input type="date" class="form-control" id="datanascimento" name="datanascimento" v-model="nascimento">
                <small class="text-danger"
                        v-if="errors.nascimento"
                        v-for="(error,n) in errors.nascimento"
                        v-bind:key="n"
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
            </div>-->
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
            <!--<div class="form-group">
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
import Http from '../http.js';
const http = new Http();

export default {
    name: 'UsuarioForm',

    data(){
        return {
            name: '',
            email: '',
            role: '',
            password: '',
            nascimento: '',
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
                password:[],
                nascimento:[]
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

            let form = new FormData();
            form.append('email', this.email);
            form.append('name',this.name);
            form.append('role',this.role);
            form.append('password',this.password);
            form.append('nascimento',this.options);
            form.append('is_featured', this.is_featured);
            form.append('options', JSON.stringify(this.options));
            form.append('token', localStorage.token);

            let resp = await axios.post('/auth/register', form);
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
            let resp = await axios.get(`/api-v1/users/${this.$route.params.id}`,{params});
            //console.warn(resp.data)
            if(resp.data.success){
                let user = resp.data.user;
                //console.log(user)
                this.name = user.name;
                this.email = user.email;
                this.role = user.options.role;
                this.nascimento = user.options.birthday;

            }
        },

        async editUsuario(){

            let params ={
                name: this.name,
                email: this.email,
                token: localStorage.token
            }

            let resp = await axios.put(`/users/${this.$route.params.id}`,params);

            console.log(resp)
        }

    }

}
</script>