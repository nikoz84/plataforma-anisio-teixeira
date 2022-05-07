<template>
    <div>
        <q-list v-if="relacionados.length > 0">
            <q-item @click="goTo(relacionado.url_exibir)" clickable v-ripple v-for="(relacionado, i) in relacionados" :key="i">
                <q-item-section thumbnail>
                    <img alt="imagem destacada"
                        height="auto"
                        loading="lazy"
                        width="100%"
                        :src="getImage(relacionado.image)" 
                    >
                </q-item-section>
                <q-item-section>
                    <strong class="related-title" :title="relacionado.title">
                        {{ relacionado.short_title }}
                    </strong>
                </q-item-section>
            </q-item>
        </q-list>
        <q-list v-else>
            <q-item>
                <q-item-section thumbnail>
                    <q-skeleton type="QAvatar" animation="fade" />
                </q-item-section>
                <q-item-section>
                    <q-skeleton type="text" animation="fade" />
                </q-item-section>
            </q-item>
            <q-item>
                <q-item-section thumbnail>
                    <q-skeleton type="QAvatar" animation="fade" />
                </q-item-section>
                <q-item-section>
                    <q-skeleton type="text" animation="fade" />
                </q-item-section>
            </q-item>
            <q-item>
                <q-item-section thumbnail>
                    <q-skeleton type="QAvatar" animation="fade" />
                </q-item-section>
                <q-item-section>
                    <q-skeleton type="text" animation="fade" />
                </q-item-section>
            </q-item>
        </q-list>
    </div>
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
    watch: {
        $route(to, from) {
            if (to.fullPath != from.fullPath) {
                this.getRelacionados();
            }
        }
    },
    methods: {
        async getRelacionados() {
            
            const {data} = await axios.get('/conteudos/relacionados/' + this.$route.params.id);
            this.relacionados = data.metadata;
        },
        goTo(url) {
            this.$router.push(url);
        },
        getImage(image) {
            return image ? image : '/img/fundo-padrao.svg';
        }
    }
}
</script>

<style scoped>

.related-title{
    line-height: 1.3;
    font-size: 0.9em;
}

</style>