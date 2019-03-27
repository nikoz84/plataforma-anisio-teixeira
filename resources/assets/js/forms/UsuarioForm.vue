<template>
    <div class="conteiner">
        <div class="row col-lg-6 col-xs-offset-3">

        <form>

            <div class="form-group">
                <label for="login">Login:*</label>
                <input type="email" class="form-control" id="login" aria-describedby="login_usuario" placeholder="Digite o login de usuário">
                <small id="login_usuario" class="form-text text-muted">Pode utilizar uma conta de e-mail como login (exemplo: aew.usuario@gmail.com, aew.usuario@hotmail.com)</small>               
            </div>

            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o completo do usuário">
            </div>

            <div class="form-group">
                <label for="tipo_usuario">Tipo usuário:*</label>
                <select class="form-control" id="tipo_usuario">
                <option value="0"> SELECIONE </option>
                <option value="1">super administrador</option>
                <option value="2">administrador</option>
                <option value="3">coordenador</option>
                <option value="4">editor</option>
                <option value="5">colaborador</option>
                </select>
            </div>

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
            <div class="form-group">
                <label for="datanascimento">Data de nascimento:</label>
                <input type="date" class="form-control" id="datanascimento" name="datanascimento">
            </div>
            <div class="form-group">
                <label for="emailinstitucional">E-mail Institucional:*</label>
                <input type="email" class="form-control" id="emailinstitucional" name="emailinstitucional">
            </div>
            <div class="form-group">
                <label for="emailpessoal">E-mail Pessoal:*</label>
                <input type="email" class="form-control" id="emailpessoal" name="emailpessoal">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
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
                <option value="">« SELECIONE »</option>
                <option value="2">Não Informado</option>
                <option value="2116">BA</option>
                <option value="2573">AC</option>
                <option value="2574">AL</option>
                <option value="2575">AP</option>
                <option value="2576">AM</option>
                <option value="2577">CE</option>
                <option value="2578">DF</option>
                <option value="2579">ES</option>
                <option value="2580">GO</option>
                <option value="2581">MA</option>
                <option value="2582">MT</option>
                <option value="2583">MS</option>
                <option value="2584">MG</option>
                <option value="2585">PA</option>
                <option value="2586">PB</option>
                <option value="2587">PR</option>
                <option value="2588">PE</option>
                <option value="2589">PI</option>
                <option value="2590">RJ</option>
                <option value="2591">RN</option>
                <option value="2592">RS</option>
                <option value="2593">RO</option>
                <option value="2594">RR</option>
                <option value="2595">SC</option>
                <option value="2596">SP</option>
                <option value="2597">SE</option>
                <option value="2598">TO</option>
            </select>
            </div>
            <div class="form-group">
                <label for="municipio">Município:</label>
                <select class="form-control form-control-lg" id="municipio">
                    <option value="">« SELECIONE »</option>
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
            </div>

            <button class="btn btn-success">Adicionar</button>

        </form>

    </div>
    </div>
</template>

<script>
import Http from '../http.js';
import TagsForm from './TagsForm.vue';
const http = new Http;

export default {
    name: 'UsuarioForm',
    data(){
        return {
            login: null,
            name: null,
            email: null,
            options: {},
            message: null,
            count: 0,
            success: false,
            isError: true,
            isUpdate: false,
            textButton: 'Criar',
            errors: {
                name: [],
                url: [],
                description: [],
                category: []
            },
        }

    },
    
    methods:{
        send(){
            if(this.isUpdate){
                this.editAplicativo();
            }else{
                this.createAplicativo();
            }
        },
        async createAplicativo(){
            this.options = {
                qt_access : 0
            }
            if(!this.image) return;
            let form = new FormData();
            form.append('name', this.name);
            form.append('description',this.description);
            form.append('category_id', this.category_id);
            form.append('canal_id', localStorage.canal_id);
            form.append('tags', this.tags);
            form.append('url', this.url);
            form.append('is_featured', this.is_featured);
            form.append('options', JSON.stringify(this.options));
            form.append('image',this.image, this.image.name);
            form.append('token', localStorage.token);

            let resp = await http.postData('/aplicativos/create', form);
            console.warn(resp);

            if(resp.data.success){
                this.$router.push({ name: 'Listar', params: {slug: this.$route.params.slug}})
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
        async getCategories(){
            let resp = await http.getDataFromUrl('/categories/aplicativos');

            this.categories = resp.data.categories;
        },
        onFileChange(e){
            this.image = e.target.files[0];
        },
        countCaracters(e){
            if(e.target.value.length > 140){
                this.success = true;
            }
            this.count = e.target.value.length;
        },
        async getAplicativo(){
            let resp = await http.getDataFromUrl(`/aplicativos/${this.$route.params.id}`);
            if(resp.data.success){
                this.name = resp.data.aplicativo.name;
                this.category_id = resp.data.aplicativo.category_id;
                this.description = resp.data.aplicativo.description;
                this.url = resp.data.aplicativo.url;
                this.is_featured = resp.data.aplicativo.is_featured;
                this.image = resp.data.aplicativo.image;
            }
        },
        async editAplicativo(){
            let params ={
                name: this.name,
                category_id: this.category_id,
                canal_id: localStorage.canal_id,
                description: this.description,
                url: this.url,
                is_featured: this.is_featured,
                token: localStorage.token
            }

            let resp = await http.config('PUT',`/aplicativos/update/${this.$route.params.id}`,params);

            console.log(resp)
        }
    }

}
</script>
