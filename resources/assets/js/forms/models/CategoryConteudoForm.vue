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
                        <div v-if="errors && errors.length > 0">
                            <ShowErrors v-for="(error, i) in errors" :key="i" :errors="error"></ShowErrors>
                        </div>
                    </q-card-section>
                    <q-card-section class="q-gutter-sm">
                        <q-input 
                             bottom-slots 
                             :error="errors.name && errors.name.length > 0"
                             filled v-model.trim="category.name" label="Nome:*" hint="Nome da Categoria por extenso"></q-input>
                        <div class="q-mt-sm">
                            <label class="text-left bold"><strong>Descrição categoria :*</strong></label>
                        </div>
                        <q-editor v-model="category.options.description" min-height="15rem" hint="Escreva uma descrição do conteúdo" />
                    </q-card-section>
                    <q-card-section>
                        <q-select
                            outlined
                            option-value="id"
                            option-label="name"
                            ransition-show="scale"
                            transition-hide="scale"
                            v-model="category.canal"
                            :options="canais"
                            label="Escolha um Canal"
                            hint="Canal ao qual pertence a categoria"
                            behavior="dialog"
                            />
                    </q-card-section>
                    <q-card-section>
                        <q-select
                            outlined
                            option-value="id"
                            option-label="name"
                            ransition-show="scale"
                            transition-hide="scale"
                            v-model="parentCategory"
                            :options="categorias"
                            label="Categoria relacionada"
                            hint="Selecione uma categoria se precisar agrupar por sub-categorias"
                            behavior="dialog"
                            />
                    </q-card-section>
                    <q-card-section>
                        <div class="q-gutter-sm">
                        <q-checkbox
                            v-model="category.options.is_active"
                            label="Ativa"
                            color="pink"
                        />
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
                        @input="val => { file = val[0];}"
                        outlined
                        bottom-slots 
                        :error="errors.imagemAssociada && errors.imagemAssociada.length > 0"
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

import { RecaptchaForm, ShowErrors } from "@forms/shared";

export default {
  name: "CategoryConteudoForm",
    data() {
        return {
            category: {
                name:"",
                canal:null,
                canal_id: null,
                imagemAssociada: "",
                options: {
                    description:"",
                    is_active:true,
                    is_featured:true
                },
                subCategories: []
            },
            parentCategory: null,
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
            if (!files.length)
                return;
            this.category.imagemAssociada = files[0];
        },
        async getData() {
            const canais  = axios.get("/canais?select");
            const categorias = axios.get("/categorias?select");
            let responses = await axios.all([canais,categorias]);
            this.canais = responses[0].data.metadata;
            this.categorias = responses[1].data.paginator.data;
            if (this.$route.params.id) {
                let category = await axios.get("/categorias/" + this.$route.params.id);
                this.category = category.data;
                console.log(this.category)
                this.categoryNome = this.category.name;
            }
            
        },

        async save() {
            const form = new FormData();
            console.log(this.parentCategory)
            
            form.append("name", this.category.name);
            form.append('parent_id', 'dd');
            form.append("options", JSON.stringify(this.category.options));
            form.append("canal_id", this.category.canal ? this.category.canal.id : null);
            form.append("imagemAssociada", this.category.imagemAssociada ? this.category.imagemAssociada : null);
            
            let url = "/categorias";
            if(this.category.id){
                url = url + `/${this.category.id}`;
                 form.append("_method", "PUT");
            }
            
            try {
                const {data} = await axios.post( url, form);
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