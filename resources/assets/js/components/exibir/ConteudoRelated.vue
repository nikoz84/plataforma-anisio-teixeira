<template>
    <q-list bordered>
        <q-item clickable v-ripple v-for="(relacionado, i) in relacionados" :key="i">
            <q-item-section thumbnail>
                <img :src="relacionado.image">
            </q-item-section>
            <q-item-section>
                <strong :title="relacionado.title">
                    {{ relacionado.short_title }}
                </strong>
            </q-item-section>
            <q-separator />
        </q-item>
    </q-list>
</template>

<script>
import {mapState} from 'vuex';

export default {
    name: 'ConteudoRelated',
    data(){
        return {
            relacionados: []
        }
    },
    computed:{
        ...mapState(['conteudo'])
    },
    created() {
        this.getRelacionados();
    },
    methods: {
        async getRelacionados() {
            
            const {data} = await axios.get('/conteudos/relacionados/' + this.$route.params.id);
            this.relacionados = data.metadata;
            console.log(this.relacionados)
        }
    }
}
</script>

<style>

</style>