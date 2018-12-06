<template>
    <div class="row">
        <form v-on:submit.prevent="createAplicativo()" enctype="multipart/form-data">
            <div class="panel panel-default col-md-7">
                <div class="panel-heading">
                    Adicionar Aplicativos
                </div>
                <div class="panel-body">
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
                        <textarea class="form-control" id="descricao" v-model="description" style="resize: none"></textarea>
                        <small class="text-danger"
                                v-if="errors.description"
                                v-for="(error,d) in errors.description"
                                v-bind:key="d"
                                v-text="error">
                        </small>
                    </div>
                    <!-- CATEGORIA -->
                    <div class="form-group" v-if="categories.length != 0">
                        <label for="estado">Categoria:*</label>
                        <select name="categoria" id="categoria" class="form-control" v-model="category">
                            <option value="">« SELECIONE »</option>
                            <option v-for="(category, i) in categories"
                                    v-bind:value="category.id"
                                    v-bind:key="i">{{category.name}}
                            </option>
                        </select>
                        <small class="text-danger"
                                v-if="errors.category"
                                v-for="(error,ca) in errors.category"
                                v-bind:key="ca"
                                v-text="error">
                        </small>
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group" v-bind:class="{ 'has-error': errors.tags && errors.tags.length > 0 }">
                        <label for="tags">Palavra-Chave:* </label>
                        <textarea class="form-control" id="tags" v-model="tags" style="resize: none"></textarea>
                        <small class="text-danger"
                                v-if="errors.tags"
                                v-for="(error,tag) in errors.tags"
                                v-bind:key="tag"
                                v-text="error">
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="imagem">Imagem destacada:</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" 
                                aria-describedby="imagem de destaque"
                                v-on:change="onFileChange($event)">
                        <small class="form-text text-muted">Imagem no formato .jpg com tamanho de 250px (altura) e 250px (largura)</small>
                        <small v-if="this.file">
                            {{ ` ${this.file.name} -- ${this.file.size} -- ${this.file.type} `}}
                        </small>
                    </div>
                    <div class="form-group">
                       <label for="destaque">Marcar como destaque</label>
                       <input type="checkbox" id="destaque" v-model="is_featured">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default">Enviar</button>
                    </div>
                    <transition  name="custom-classes-transition"
                            enter-active-class="animated shake"
                            leave-active-class="animated fadeOut">
                    <div v-if="!isError" class="alert alert-info" role="alert" >
                        {{ message }}
                    </div>
                    </transition>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Http from '../http.js';

const http = new Http;

export default {
    name: 'AplicativoForm',
    data(){
        return {
            name:null,
            description:null,
            url: null,
            is_featured: false,
            tags: null,
            options: {},
            file: null,
            category: '',
            categories:[],
            message: null,
            isError: true,
            errors: {
                name: [],
                url: [],
                description: [],
                category: [],
                tags: [],
            },
        }

    },
    created(){
        this.getCategories();
    },
    methods:{
        async createAplicativo(){
            this.options = {
                qt_access : 0
            }
            let data = {
                name: this.name,
                description:this.description,
                category: this.category,
                canal: localStorage.idCanal,
                tags: this.tags,
                url: this.url,
                is_featured: this.is_featured,
                options: JSON.stringify(this.options),
                token: localStorage.token
            };
            console.warn(data)

            let resp = await http.postData('/aplicativos/create', data);

            if(resp.data.success){
                console.warn(resp.data.message)

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

        },
        async getCategories(){
            let resp = await http.getDataFromUrl('/categories/aplicativos');

            this.categories = resp.data.categories;
        },
        onFileChange(e){
            
            let file = e.target.files[0];
            this.file = file;
            let fd = new FormData();
            fd.append('image',file, file.name)
            let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
            let params = {
                        image: file
                };
            axios.post('/api-v1/files/150',fd).then((resp) => console.warn(resp.data));
        }
    }

}
</script>
