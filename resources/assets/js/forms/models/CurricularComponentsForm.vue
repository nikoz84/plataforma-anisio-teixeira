<template>
    
    <div class="row q-pa-md">
      
      <div class="col-sm-12">
        <h5 v-if="curricularComponent.id != null">Edição Componente Curricular <b>{{curricularComponent.name}}</b></h5>
        <h5 v-if="curricularComponent.id == null">Cadastro de Componente Curricular</h5>
        <form v-on:submit.prevent="save()">
            <q-input filled v-model.trim="curricularComponent.name" label="Nome do Componente" 
                    hint="Nome abreviado ou reduzido"
                    :error="errors && errors.name && errors.name.length > 0"
                    bottom-slot
                />
                <q-select outlined option-value="id" option-label="name" ransition-show="scale" transition-hide="scale"
                    v-model="curricularComponent.category" :options="categories" label="Categoria relacionada"
                    hint="Selecione uma categoria ao qual este componente curricular pertence"
                    behavior="dialog"
                />
            <q-select outlined option-value="id" option-label="name" ransition-show="scale" transition-hide="scale"
                    v-model="curricularComponent.nivel" :options="niveisEnsino" label="Nível Ensino relacionado"
                    hint="Selecione uma categoria ao qual este componente curricular pertence"
                    behavior="dialog"
                />
            <q-item-label style="margin-bottom:10px" >
                <q-icon name="image" style="padding-bottom: 3px;" /><strong>Icone Imagem</strong>
            </q-item-label>
            <q-img 
                loading="lazy" 
                style="height:150px; width:150px"
                :src="curricularComponent.icon"
                placeholder-src="/img/fundo-padrao.svg"
                alt=" Icone da categoria :"/>
            <br>
            <q-btn
            class="full-width"
            color="primary"
            @click="save()"
            label="Salvar"
            ></q-btn>
        </form>

      </div>
    </div>
</template>
<script>
import {
  QInput,
  QEditor,
  QCard,
  QCardSection,
  QBtn,
  QToggle,
  QColor,
  QStepper,
  QStep,
  QStepperNavigation
} from "quasar";
import { ShowErrors } from '@forms/shared';
export default {
    name: 'CurricularComponentsForm',
    components: {
        ShowErrors
    },
    data() 
    {
        return {
            step: 1,
            curricularComponent:{
                id:null,
                name:"",
                nivel_id:null,
                nivel:null,
                categories:[],
                niveis:[]
            },
            errors: [],
            categories:[],
            niveisEnsino:[]
        }  
    },
     created() 
     {
        this.getComponente();
        this.getCategories();
        this.getNiveisEnsino();
     },
     methods: 
     {
         async getNiveisEnsino()
         {
              let resp = await axios.get(`/nivelensino`);
              this.niveisEnsino = resp.data.paginator.data
              console.log("niesensinos", this.niveisEnsino);
              //this.curricularComponent = resp.data;
         },
         async save() {
            const form = new FormData();
            form.append("name", this.curricularComponent.name);
            if(this.curricularComponent.nivel) {
                form.append("nivel_id", this.curricularComponent.nivel.id);
            }
            if(this.curricularComponent.category) {
                form.append("category_id", this.curricularComponent.category.id);
            }

            try {
                let url = '/componentes'
                
                if (this.$route.params.id) {
                    form.append("id", this.curricularComponent.id);    
                    form.append("_method", "PUT");
                    url = url + `/${this.$route.params.id}`
                } 
                
                const resp = await axios.post(url, form);
                
                if(resp.status === 200){
                    this.$router.push(`/admin/componentes/listar`)
                }
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         },
         async getCategories() {
            let resp = await axios.get("/componentes");
            console.log("resp", resp)
            if (resp.data.success) {
               this.categories = resp.data.paginator.data;
            }
        },
        async getComponente() 
        {
            if (!this.$route.params.id) 
            {
                return;
            }
            let resp = await axios.get(`/componentes/${this.$route.params.id}`);
            this.curricularComponent = resp.data;
            console.log("curricularComponent",this.curricularComponent);
        },
        searchCategories(val, update, abort) 
         {
            update(() => 
            {
                if (val === "" && val.length < 2) {
                this.categories = [];
                } else {
                const self = this;
                axios.get(`componentes/autocomplete/${val}`).then(resp => {
                    self.categories = resp.data.metadata;
                });
                }
            });
        },
        searchNiveis(val, update, abort) 
         {
            update(() => 
            {
                if (val === "" && val.length < 2) {
                this.niveis = [];
                } else {
                const self = this;
                axios.get(`nivelensino/autocomplete/${val}`).then(resp => {
                    self.niveisEnsino = resp.data.metadata;
                });
                }
            });
        }
     }
}
</script>