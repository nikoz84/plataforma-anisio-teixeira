<template>
    <div class="row q-pa-md">
        <div class="col-sm-12" style="padding:5px">
            <q-card flat bordered>
                <h5 v-if="nivelEnsino.id != null">Edição do Nível de Ensino <b>{{this.nivelEnsinoNome}}</b></h5>
                <h5 v-if="nivelEnsino.id == null">Cadastro do Nível de Ensino</h5>
                <form v-on:submit.prevent="save()">
                    <ShowErrors :errors="errors.name"></ShowErrors>
                    <q-input filled v-model.trim="nivelEnsino.name" label="Nome da Categoria do Componente" 
                        hint="Nome abreviado ou reduzido"
                        :error="errors && errors.name && errors.name.length > 0"
                        bottom-slot
                    />
                    <q-item-label v-if="nivelEnsino.id != null" style="margin-bottom:5px" ><q-icon name="list" style="padding-bottom: 3px; padding-top: 3px; height:15px; width:15px" /><strong>Componentes</strong></q-item-label>
                    <q-select class="col-sm-10"
                        v-if="nivelEnsino.id != null"
                        filled
                        readonly="readonly"
                        v-model="nivelEnsino.componentes"
                        use-input
                        multiple
                        option-value="id"
                        option-label="name"
                        use-chips
                        hint="Adicione Componentes Curriculares"
                        input-debounce="300"
                        new-value-mode="add-unique"
                        :options="this.componentes"
                        @filter="getComponentes"
                        bottom-slots
                        :error="errors.componentes && errors.componentes.length > 0" />
                    <q-btn
                    class="full-width"
                    color="primary"
                    @click="save()"
                    label="Salvar"
                    ></q-btn>
                </form>
            </q-card>
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
    name: 'NivelEnsinoForm',
    components: {
        ShowErrors
    },
    created(){
        this.getNivelEnsino() ;
        
    },
    data() 
    {
        return {
            nivelEnsino:{
                name:"",
                id:null,
                componentes:[]
            },
            errors:[],
            componentes:[],
            nivelEnsinoNome:""
        }
    },
    methods:{
         async save() 
         {
            const form = new FormData();
            form.append("name", this.nivelEnsino.name);
            if (this.nivelEnsino.componentes.length) 
            {
                let componentes = this.nivelEnsino.componentes.map(item => item.id);
                for (var i = 0; i < componentes.length; i++) 
                {
                    form.append("componentes[]", componentes[i]);
                }
            }
            try
            {
                if (this.$route.params.action == "editar") 
                {
                    form.append("id", this.nivelEnsino.id);    
                    form.append("_method", "PUT");
                    let resp = await axios.post(this.$route.params.slug +"/"+ this.nivelEnsino.id, form);
                }
                else
                {
                    let resp = await axios.post(this.$route.params.slug , form);
                }
                this.$router.push(`/admin/nivelensino/listar`);
            }
            catch(ex)
            {
                this.errors = ex.errors;
            }
         },
        getComponentes(val, update, abort) 
         {
            update(() => 
            {
                if (val === "" && val.length < 2) {
                this.componentes = [];
                } else {
                const self = this;
                axios.get(`componentes/autocomplete/${val}`).then(resp => {
                    self.componentes = resp.data.metadata;
                });
                }
            });
        },
        async getNivelEnsino()
        {
            if (!this.$route.params.id) 
            {
                return;
            }
            let resp = await axios.get(`/nivelensino/${this.$route.params.id}`);
            this.nivelEnsino = resp.data;

            console.log("nivelensino",this.nivelEnsino);
            this.nivelEnsinoNome = this.nivelEnsino.name;
        }
    }
}
</script>