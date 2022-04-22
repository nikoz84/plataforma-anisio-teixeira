<template>
    <div class="row q-pa-md">
        <div class="col-sm-12" style="padding:5px">
            <q-card flat bordered>
                <h5>Nível de Ensino</h5> 
                <form v-on:submit.prevent="save()">
                    <ShowErrors :errors="errors.name"></ShowErrors>
                    <q-input filled v-model.trim="nivelEnsino.name" 
                        label="Nome do nível de ensino" 
                        :error="errors && errors.name && errors.name.length > 0"
                        bottom-slot
                    />
                    <q-item-label v-if="nivelEnsino.id != null" style="margin-bottom:5px" >
                        <q-icon name="list" 
                        style="padding-bottom: 3px; padding-top: 3px; height:15px; width:15px" />
                        <strong>Componentes</strong>
                    </q-item-label>
                    <q-select class="col-sm-10"
                        
                        filled
                        label="Adicione Componentes Curriculares"
                        v-model="nivelEnsino.componentes"
                        use-input
                        multiple
                        option-value="id"
                        option-label="name"
                        use-chips
                        
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
               let url = '/niveis-ensino'

               if(this.$route.params.id){
                   form.append("id", this.nivelEnsino.id);
                   form.append("_method", "PUT");
                   url = url + `/${this.$route.params.id}`
               }

               const resp = await axios.post(url, form);

               if(resp.status === 200){
                   this.$router.push(`/admin/niveis-ensino/listar`)
               }
                
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
                axios.get(`niveis-ensino/autocomplete/${val}`).then(resp => {
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
            let {data} = await axios.get(`/niveis-ensino/${this.$route.params.id}`);

            console.log(data)
            this.nivelEnsino = data.metadata;

            console.log("nivelensino",this.nivelEnsino);
            this.nivelEnsinoNome = this.nivelEnsino.name;
        }
    }
}
</script>