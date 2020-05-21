<template>
    <div class="q-ma-md row justify-center">
        <ul style="list-style: none;">
            <li v-for="(conteudo, i) in conteudos" :key="i">
                <h6 class="text-h6">{{ conteudo.title }}</h6>
                <div class="justify-center">
                    <q-btn color="primary"
                        icon="edit"
                        :to="`/conteudos/editar/${conteudo.id}`"
                        v-if="conteudo.user_can.update"/>
                    <q-btn color="negative" v-if="conteudo.user_can.delete" icon="delete"/>    
                </div>
            </li>
            
        </ul>
    </div>
</template>

<script>
export default {
    name: "ConteudoAdmin",
    data(){
        return {
            conteudos : []
        }
    },
    mounted() {
        this.getConteudos();
        console.warn(this.$route)
    },
    methods: {
        async getConteudos(){
            let {data} = await axios.get('/conteudos');
            if (data.success){
                this.conteudos = data.paginator.data
            }
        }
    },
}
</script>
