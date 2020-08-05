<template>
    <div class="row q-gutter-xs">
        <form class="col-sm-12" v-on:submit.prevent="save()">
            
            <div class="row">
                <q-card class="col-sm-12">
                    <q-card-section class="q-gutter-sm">
                        <template v-slot:error>
                            <ShowErrors :errors="errors.name"></ShowErrors>
                        </template>
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
                            v-model="category.subCategories"
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
                            label="Aprovar conteúdo"
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
                        <q-item-label style="margin-bottom:10px" ><q-icon name="image" style="padding-bottom: 3px;" /><strong>Imagem Associada</strong></q-item-label>
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
                     <q-card-section>
                        <q-item-label style="margin-bottom:10px" ><q-icon name="videocam" style="padding-bottom: 3px;" /><strong>Video Destaque</strong></q-item-label>
                        
                        <q-video v-if="category.video"
                            :ratio="16/9"
                            :src="category.video"
                        />
                        <q-input
                        class="q-mt-md"
                        @input="val => {file = val[0];}"
                        outlined
                        type="file"
                        filled
                        :error="errors.videoDestaque && errors.videoDestaque.length > 0"
                        @change="onFileVideoChange"
                        counter
                        accept=".webm"
                        max-file-size="102400000"
                        hint="Vídeo no formato .webm, tamanho máximo: 50MB"/>
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
<script>
import { RecaptchaForm, ShowErrors } from "@forms/shared";
export default {
    name: "CategoryConteudoForm",
    computed: {
        url() 
        {
            return `http://${window.location.hostname}/${slug}`;
        }
    },
    data() {
        return {
            category: {
                name:"",
                canal:null,
                canal_id: null,
                imagemAssociada: "",
                videoDestaque:"",
                options: {
                    description:"",
                    is_active:true,
                    is_featured:true
                },
                subCategories:[]
            },
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
        onFileVideoChange(e){
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.category.videoDestaque = files[0];
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
                console.log( this.category)
            }
        },

        async save() {
            const form = new FormData();
            form.append("name", this.category.name);
            form.append("options", JSON.stringify(this.category.options));
            if(this.category.canal)
            form.append("canal_id", this.category.canal.id);
            if(this.category.imagemAssociada)
            form.append("imagemAssociada", this.category.imagemAssociada);
            if(this.category.videoDestaque)
            form.append("videoDestaque", this.category.videoDestaque);
            try{
                if (this.$route.params.action == "editar") 
                {
                    form.append("id", this.category.id);    
                    form.append("_method", "PUT");
                    let resp = await axios.post(this.$route.params.slug +"/"+ this.category.id, form);
                }
                else
                {
                    let resp = await axios.post(this.$route.params.slug , form);
                }
                this.$router.push(`/admin/categorias/listar`);
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         }
    }
}
</script>