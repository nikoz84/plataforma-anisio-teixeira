<template>
    <q-card v-if="conteudo">
        <q-card-section>
            <strong>Publicado em: </strong>
                {{conteudo.formated_date}}
                
            <q-separator class="q-my-md"></q-separator>
            
            <strong>Fonte:</strong>
                {{ conteudo.source ? conteudo.source : null }}

            <q-separator class="q-my-md"></q-separator>
            
            <strong>Autores:</strong>
                <i class="break-word">
                    {{conteudo.authors ? conteudo.authors : null}}
                </i>
            
            <q-separator class="q-my-md"></q-separator>
            
            <strong>Licença:</strong>
                {{conteudo.lincese ? conteudo.license.name : null}}

            <q-separator class="q-my-md"></q-separator>

            <strong>
                Publicador(a):
            </strong>
            <q-chip dense
                    color="blue-grey-6" 
                    text-color="white"
                    clickable
                    :label="conteudo.user ? conteudo.user.name: null"
                    @click="onClick(`/recursos-educacionais/listar?publicador=${conteudo.user.id}`)">
                    <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                        Outros conteúdos deste publicador
                    </q-tooltip>
            </q-chip>
            
            <q-separator class="q-my-md"></q-separator>

            <strong >Componentes:</strong>
            <q-chip dense
                    color="blue-grey-6" 
                    text-color="white"
                    v-for="(componente) in conteudo.componentes"
                    :key="`c-${componente.id}`"
                    :label="componente.name"
                    clickable
                    @click="onClick(`/recursos-educacionais/listar?componentes=${componente.id}`)"
                >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Procurar por: {{componente.name}}
                </q-tooltip>
            </q-chip>
            
            <q-separator class="q-my-md"></q-separator>

            <TagList :items="conteudo.tags" title="Tags" slug="tag"></TagList>
        </q-card-section>
    </q-card>      
</template>

<script>
import { mapState } from "vuex"
import TagList from "./TagList.vue";

export default {
    name : "ConteudoMetadata",
    components: {TagList},
    computed: {
        ...mapState(['conteudo'])
    },
    methods: {
        onClick(url) {
            this.$router.push(url);
        }
    },
}
</script>

<style lang="stylus" scoped>

</style>