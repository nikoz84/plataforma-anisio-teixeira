<template>
    <div class="row q-gutter-xs">
        <form class="col-sm-12" v-on:submit.prevent="save()">

            <div class="row">
                <q-card class="col-12">
                    <q-btn
                        class="full-width"
                        color="primary"
                        @click="save()"
                        label="Salvar"
                        ></q-btn>
                </q-card>
                <q-card class="col-sm-12">
                    <q-card-section class="q-gutter-sm">
                        <q-input filled v-model.trim="category.name" label="Nome:*" hint="Nome da Categoria por extenso"></q-input>
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
                        <q-img 
                        loading="lazy" 
                        width="100%" 
                        height="200" 
                        :src="category.image"
                        placeholder-src="/img/fundo-padrao.svg"
                        alt=" Icone da categoria :"/>
                        <q-input
                        @input="val => { file = val[0];}"
                        outlined
                        accept=".png, .webp, .svg, .jpeg, .jpg"
                        type="file"
                        hint="Imagem de Destaque"
                        />

                        <q-input
                        class="q-mt-md"
                        @input="val => {file = val[0];}"
                        outlined
                        type="file"
                        filled
                        counter
                        accept=".webm"
                        max-file-size="102400000"
                        hint="Vídeo no formato .webm, tamanho máximo: 50MB"
                        />
                    </q-card-section>
                </q-card>
            </div>
        </form>
    </div>
</template>
<script>
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
                canal_id: null,
                image: "",
                options: {
                    description:"",
                    is_active:true,
                    is_featured:true
                },
                subCategories:[]
            },
            canais: [],
            categorias:[]
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        async getData() {
            const canais  = axios.get("/canais?select");
            const categorias = axios.get("/categorias?select");
            let responses = await axios.all([canais,categorias]);
            this.canais = responses[0].data.metadata;
            this.categorias = responses[1].data.paginator.data;
            console.log("responses[0]",responses[0]);
            console.log("responses[1]",responses[1]);
            if (this.$route.params.id) {
                let category = await axios.get("/categorias/" + this.$route.params.id);
                this.category = category.data;
            }
            
        },
        async save() {
            console.log(this.category);
            const form = new FormData();
            form.append("name", this.category.name);
            form.append("options", JSON.stringify(this.category.options));
            form.append("canal_id", this.category.canal.id);
            if (this.$route.params.action == "editar") 
            {
                form.append("id", this.category.id);    
                form.append("_method", "PUT");
                let resp = await axios.put(this.$route.params.slug +"/"+ this.category.id, form);
                console.log(this.$route.params.slug+"/"+ this.category.id);
            }
            else
            {
                let resp = await axios.post(this.$route.params.slug , form);
            }
            console.log(resp.data)
            // if (resp.data.success) {
            //     this.$q.notify({
            //     message: resp.data.message,
            //     color: "grey-4",
            //     textColor: "primary",
            //     possition: "center"
            //     });
            // } else {
            //     this.$q.notify({
            //     message: resp.data.message,
            //     color: "grey-4",
            //     textColor: "primary",
            //     possition: "center"
            //     });
            // }
         }
    }
}
</script>