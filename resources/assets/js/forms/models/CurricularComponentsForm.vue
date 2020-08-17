<template>
    
    <div class="row q-pa-md">
      
      <div class="col-sm-12">
        <h5 v-if="curricularComponent.id != null">Edição Componente Curricular <b>{{curricularComponent.name}}</b></h5>
        <h5 v-if="curricularComponent.id == null">Cadastro de Componente Curricular</h5>
        <form v-on:submit.prevent="save()">
            <ShowErrors :errors="errors.name"></ShowErrors>
            <q-input filled v-model.trim="curricularComponent.name" label="Nome do Componente" 
                    hint="Nome abreviado ou reduzido"
                    :error="errors && errors.name && errors.name.length > 0"
                    bottom-slot
                />
                <q-select outlined option-value="id" option-label="name" ransition-show="scale" transition-hide="scale"
                    v-model="curricularComponent.category" :options="categorias" label="Categoria relacionada"
                    hint="Selecione uma categoria se precisar agrupar por sub-categorias"
                    behavior="dialog"
                />
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
import { ShowErrors } from '@forms/shared'
export default {
    name: 'CurricularComponentsForm',
    data() 
    {
        return {
            step: 1,
            curricularComponent:{
                id:null,
                name:"",
                nivel_id:null,
                nivel:null,
                category:null
            },
            errors: [],
            categorias:[]
        }  
    },
     created() 
     {
        this.getComponente();
        this.getCategories();
     },
     methods: 
     {
        async save() {
            const form = new FormData();
            form.append("name", this.curricularComponent.name);
            if(this.curricularComponent.category)
            {
                form.append("category_id", this.curricularComponent.category.id);
            }
            try
            {
                if (this.$route.params.action == "editar") 
                {
                    form.append("id", this.curricularComponent.id);    
                    form.append("_method", "PUT");
                    let resp = await axios.post(this.$route.params.slug +"/"+ this.curricularComponent.id, form);
                }
                else
                {
                    let resp = await axios.post(this.$route.params.slug , form);
                }
                this.$router.push(`/admin/componentes/listar`);
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         },
         async getCategories() {
            let resp = await axios.get("/componentescategorias");
            console.log("resp", resp)
            if (resp.data.success) {
                this.categorias = resp.data.paginator.data;
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
        }
     }
}
</script>