<template>

    <div class="row q-pa-md">

        <div class="col-sm-12">
            <h5 v-if="curricularComponentCategory.id != null">Edição da Categoria Componente Curricular <b>{{this.categoryName}}</b></h5>
            <h5 v-if="curricularComponentCategory.id == null">Cadastro da Categoria Componente Curricular</h5>
             <form v-on:submit.prevent="save()">
                 <ShowErrors :errors="errors.name"></ShowErrors>
                 <q-input filled v-model.trim="curricularComponentCategory.name" label="Nome da Categoria do Componente" 
                    hint="Nome abreviado ou reduzido"
                    :error="errors && errors.name && errors.name.length > 0"
                    bottom-slot
                />
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
    name: 'CurricularComponentsCategoryForm',
    components: {
        ShowErrors
    },
    data() 
    {
        return {
            step: 1,
            curricularComponentCategory:{
                id:null,
                name:"",
            },
            categoryName:"",
            errors:[]
        }
    },
    created(){
        this.getComponenteCategoria() ;
        
    },
    methods: 
     {
        async save() {
            const form = new FormData();
            form.append("name", this.curricularComponentCategory.name);
            try
            {
                if (this.$route.params.action == "editar") 
                {
                    form.append("id", this.curricularComponentCategory.id);    
                    form.append("_method", "PUT");
                    let resp = await axios.post(this.$route.params.slug +"/"+ this.curricularComponentCategory.id, form);
                }
                else
                {
                    let resp = await axios.post(this.$route.params.slug , form);
                }
                this.$router.push(`/admin/componentescategorias/listar`);
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         },
         async getComponenteCategoria() 
        {
            if (!this.$route.params.id) 
            {
                return;
            }
            let resp = await axios.get(`/componentescategorias/${this.$route.params.id}`);
            this.curricularComponentCategory = resp.data;
            this.categoryName = this.curricularComponentCategory.name;
        }
    }
}

</script>