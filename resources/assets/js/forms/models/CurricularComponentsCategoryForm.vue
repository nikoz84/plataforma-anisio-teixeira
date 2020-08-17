<template>

    <div class="row q-pa-md">

        <div class="col-sm-12">
            <h5 v-if="curricularComponent.id != null">Edição Componente Curricular <b>{{curricularComponent.name}}</b></h5>
            <h5 v-if="curricularComponent.id == null">Cadastro de Componente Curricular</h5>
            <form v-on:submit.prevent="save()">
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

export default {
    name: 'CurricularComponentsCategoryForm',
    data() 
    {
        return {
            step: 1,
            curricularComponentCategory:{
                id:null,
                name:"",
            }
        }
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
                this.$router.push(`/admin/componentes/listar`);
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         },
    }
}

</script>