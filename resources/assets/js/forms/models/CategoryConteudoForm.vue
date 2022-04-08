<template>
    <div class="row q-pa-md">
      
        <form class="col-sm-12" v-on:submit.prevent="save()">
            
            <div class="row">
                <q-card class="col-sm-12">
                    <q-card-section>
                        <h5 v-if="category.id != null">Edição da categoria: 
                            <b>{{this.categoryNome}}</b>
                        </h5>
                        <h5 v-else>
                            Criar nova categoria
                        </h5>
                    </q-card-section>
                    <q-card-section class="q-gutter-sm">
                        <q-input 
                             bottom-slots
                             :error="errors && errors.name && errors.name.length > 0"
                             filled 
                             v-model.trim="category.name" 
                             label="Nome campo obrigatório">
                            <template v-slot:error>
                                <ShowErrors :errors="errors.name"></ShowErrors>
                            </template>
                        </q-input>
                        <div class="q-mt-sm">
                            <label class="text-left bold"><strong>Descrição categoria :*</strong></label>
                        </div>
                        <q-editor v-model="category.options.description" 
                            min-height="15rem" 
                            hint="Escreva uma descrição do conteúdo" />
                        
                    </q-card-section>
                    <q-card-section>
                        <q-select
                            outlined
                            option-value="id"
                            option-label="name"
                            emit-value
                            map-options
                            ransition-show="scale"
                            transition-hide="scale"
                            v-model="category.canal_id"
                            :options="canais"
                            label="Escolha um Canal"
                            hint="Canal ao qual pertence a categoria"
                            behavior="dialog"
                            @input="filter()"
                            bottom-slots
                            :error="errors && errors.canal_id && errors.canal_id.length > 0"
                            >
                            <template v-slot:error>
                                <ShowErrors :errors="errors.canal_id"></ShowErrors>
                            </template>
                        </q-select>
                    </q-card-section>
                    <q-card-section v-if="filterCategories.length > 0">
                        <q-select
                            outlined
                            option-value="id"
                            option-label="name"
                            emit-value
                            map-options
                            ransition-show="scale"
                            transition-hide="scale"
                            v-model="category.parent_id"
                            :options="filterCategories"
                            label="Categoria relacionada"
                            hint="Selecione uma categoria se precisar agrupar por sub-categorias"
                            behavior="dialog"
                            :error="errors && errors.parent_id && errors.parent_id.length > 0"
                            >
                            <template v-slot:error>
                                <ShowErrors :errors="errors.parent_id"></ShowErrors>
                            </template>
                        </q-select>
                    </q-card-section>
                    <q-card-section>
                        <div class="q-gutter-sm">
                        
                        <q-checkbox
                            v-model="category.options.is_active"
                            label="Ativa"
                            color="pink"
                        />
                        </div>
                        <div class="q-gutter-sm">

                            <q-checkbox
                                v-model="category.options.is_featured"
                                label="Marcar como destaque"
                                color="pink"
                            />
                        </div>
                        
                    </q-card-section>
                    <q-card-section>
                        <q-item-label style="margin-bottom:10px" >
                            <q-icon name="image" style="padding-bottom: 3px;" />
                                <strong>Imagem Associada</strong>
                            </q-item-label>
                        <q-img 
                        loading="lazy" 
                        style="height:150px; width:150px"
                        :src="category.image"
                        placeholder-src="/img/fundo-padrao.svg"
                        alt=" Icone da categoria :"/>
                        <q-input
                        @input="val => {file = val[0];}"
                        outlined
                        bottom-slots 
                        :error="errors && errors.image && errors.image.length > 0"
                        @change="onFileChange"
                        accept=".png, .webp, .svg, .jpeg, .jpg"
                        type="file"
                        hint="Imagem de Destaque"
                        />
                    </q-card-section>
                     
                </q-card>
                <q-card class="col-12">
                    <q-btn
                        class="full-width"
                        color="primary"
                        @click="save()"
                        label="Salvar"
                        ></q-btn>
                </q-card>
            </div>
        </form>
    </div>
</template>
<script>// @ts-nocheck

import { ShowErrors } from "@forms/shared";

export default {
  name: "CategoryConteudoForm",
    components: {ShowErrors},
    data() {
        return {
            category: {
                name: "",
                canal_id: null,
                parent_id: null,
                image: "",
                options: {
                    description: "",
                    is_active: false,
                    is_featured: false
                }
            },
            filterCategories: [],
            uploadImage: null,
            canais: [],
            categorias:[],
            errors:{}
        }
    },
    mounted() {
        this.getData();
        
    },
    methods: {
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.uploadImage = files[0];
        },
        async getData() {
            const {data}  = await axios.get("/canais?select");
            this.canais = data.metadata;
            
            if (this.$route.params.id) {
                let category = await axios.get("/categorias/" + this.$route.params.id);
                this.category = category.data;
                this.categoryNome = this.category.name;

                await this.filter()
            }
            
        },

         async filter(){
            this.$q.loading.show({
                message: 'Carregando...'
            })
            const {data} = await axios.get(`/categorias/canal/${this.category.canal_id}`);
            console.log(this.category)
            if(data.success == true){
                this.filterCategories = data.metadata.categories;
                this.$q.loading.hide();
            }
            this.$q.loading.hide();
            
        },
        async save() {
            const form = new FormData();
            this.$q.loading.show();
            
            form.append('category', JSON.stringify(this.category))
            form.append('featured_image', this.uploadImage);
            
            let url = "/categorias";
            if(this.$route.params.id){
                url = url + `/${this.category.id}`;
                form.append("_method", "PUT");
            }
            
            try {
                const {data} = await axios.post(url, form);
                this.$q.loading.hide();
                if(data.success == true){
                    this.$router.push(`/admin/categorias/listar`);
                }
            } catch(ex){
                this.errors = ex.errors
            }
             
         }
    }
}
</script>