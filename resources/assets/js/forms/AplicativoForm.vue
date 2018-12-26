<template>
    <div class="row">
        <div class="panel panel-default col-md-8">
            <div class="panel-heading">
                Adicionar Aplicativos
            </div>
            <div class="panel-body">
                <form v-on:submit.prevent="send()">
                    <!-- TITULO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.name && errors.name.length > 0 }">
                        <label for="nomeaplicativo">Nome do aplicativo:*</label>
                        <input type="text"
                                class="form-control"
                                name="nomeaplicativo"
                                id="nomeaplicativo"
                                v-model.trim="name">
                        <small class="text-danger"
                                v-if="errors.name"
                                v-for="(error,n) in errors.name"
                                v-bind:key="n"
                                v-text="error">
                        </small>
                    </div>
                    <!-- CATEGORIA -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.category_id && errors.category_id.length > 0 }">
                        <label for="estado">Categoria:*</label>
                        <select name="categoria" 
                                id="categoria" 
                                class="form-control" 
                                v-model="category_id">
                            <option value="">« SELECIONE »</option>
                            <option v-for="(category, i) in categories"
                                    v-bind:value="category.id"
                                    v-bind:key="i">{{category.name}}
                            </option>
                        </select>
                        <small class="text-danger"
                                v-if="errors.category_id"
                                v-for="(error,ca) in errors.category_id"
                                v-bind:key="ca"
                                v-text="error">
                        </small>
                    </div>
                    <!-- URL -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.url && errors.url.length > 0 }">
                        <label for="url">URL:*</label>
                        <input type="text" class="form-control" id="url" v-model="url" v-model.trim="url">
                        <small class="text-danger"
                                v-if="errors.url"
                                v-for="(error,u) in errors.url"
                                v-bind:key="u"
                                v-text="error">
                        </small>
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.description && errors.description.length > 0 }">
                        <label for="descricao">Descrição:*</label>
                        <textarea class="form-control"
                                    id="descricao"
                                    rows="15"
                                    cols="50"
                                    v-model="description"
                                    style="resize: none"
                                    v-on:keyup="countCaracters($event)"></textarea>
                        <span class="pull-right" v-bind:class="{'text-success': success }">
                            {{ count }}
                        </span>
                        <small class="text-danger"
                                v-if="errors.description"
                                v-for="(error,d) in errors.description"
                                v-bind:key="d"
                                v-text="error">
                        </small>
                    </div>
                    <!-- DESTAQUE -->
                    <div class="form-group">
                       <label for="destaque">Marcar como destaque</label>
                       <input type="checkbox" id="destaque" v-model="is_featured">
                    </div>
                    <!-- ENVIAR -->
                    <div class="form-group">
                        <button class="btn btn-default" > {{ textButton }} </button>
                    </div>
                </form>
                <transition  name="custom-classes-transition"
                        enter-active-class="animated shake"
                        leave-active-class="animated fadeOut">
                    <div v-if="!isError" class="alert alert-info" role="alert" >
                        {{ message }}
                    </div>
                </transition>
            </div>
        </div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading">
                Adicione uma imagem
            </div>
            <div class="panel-body">
                <!-- IMAGEM -->
                <div class="form-group" v-bind:class="{ 'has-error': errors.image && errors.image.length > 0 }">
                    <img class="img-responsive" width="150" height="150" v-if="image" :src="image">
                    <input type="file" class="form-control" id="imagem" name="imagem"
                            aria-describedby="imagem de destaque"
                            v-on:change="onFileChange($event)">
                    <small class="form-text text-muted">Escolha uma imagem</small><br>
                    <small class="text-danger"
                            v-if="errors.image"
                            v-for="(error,f) in errors.image"
                            v-bind:key="f"
                            v-text="error">
                    </small>
                    <!--<small v-if="this.file">
                        {{ ` ${this.file.name} -- ${this.file.size} -- ${this.file.type} `}}
                    </small>-->
                </div>
                <TagsForm/>
            </div>
        </div>        
    </div>
</template>

<script>
import Http from '../http.js';
import TagsForm from './TagsForm.vue';
const http = new Http;

export default {
    name: 'AplicativoForm',
    components: {TagsForm},
    data(){
        return {
            name: null,
            description: null,
            url: null,
            is_featured: false,
            tags: null,
            options: {},
            image: null,
            category_id: '',
            categories:[],
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
    created(){
        this.getCategories();
        if(this.$route.params.update){
            this.getAplicativo();
            this.isUpdate = true;
            this.textButton = 'Editar';
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
