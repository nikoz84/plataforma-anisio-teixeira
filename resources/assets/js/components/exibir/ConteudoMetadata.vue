<template>
    <div v-if="conteudo">
        <q-card-section>
            <div v-if="conteudo.title">
                <strong>Título:</strong>
                <Title :title="conteudo.title"></Title>
                <q-separator class="q-my-md"></q-separator>
            </div>
            <div v-if="conteudo.description">
                <strong>Descrição:</strong>
                <div class="q-mt-md" v-html="conteudo.description"></div>
                <q-separator class="q-my-md"></q-separator>
            </div>
            <div v-if="conteudo.tipo">
                <strong>Tipo de Conteúdo:</strong> 
                <q-badge outline align="middle" color="teal-10">
                    {{conteudo.tipo.name}}
                </q-badge>
                <q-separator class="q-my-md"></q-separator>
            </div>
            <div v-if="conteudo.qt_access">
                <strong>Quantidade de acessos:</strong> 
                <q-badge outline align="middle" color="teal-10">{{conteudo.qt_access}}</q-badge>
                <q-separator class="q-my-md"></q-separator>
            </div>
            <div v-if="conteudo.tipo && conteudo.tipo.id != 8 && conteudo.qt_downloads > 0">
                <strong >
                    Downloads: 
                </strong>
                <q-badge outline align="middle" color="teal-10">
                    {{conteudo.qt_downloads}}
                </q-badge>
                <q-separator class="q-my-md">
                </q-separator>
            </div>    
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
            
            <strong>
                Publicador(a):
            </strong>
            <q-chip dense
                    color="blue-grey-6" 
                    text-color="white"
                    clickable
                    :label="conteudo.user ? conteudo.user.name: null"
                    @click="onClick(`/recursos-educacionais/listar?publicador=${conteudo.user.id}`)">
                    <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px;word-break: break-word;">
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
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px;word-break: break-word;">
                    Procurar por: {{componente.name}}
                </q-tooltip>
            </q-chip>
            
            <q-separator class="q-my-md"></q-separator>

            <TagList :items="conteudo.tags" title="Palavras Chave" slug="tag"></TagList>

            <q-separator class="q-my-md"></q-separator>
            <div v-if="conteudo.license">
                <strong>Licença: {{ conteudo.license.name }}</strong>
                <p class="q-mt-lg">{{conteudo.license.description}}</p>
                <q-separator class="q-my-md"></q-separator>
                <!--p class="q-mt-lg text-primary" >
                    Todos os conteúdos postados em esse site são responsabilidade 
                de cada <strong>publicador</strong> ou <strong>projeto</strong>
                </p>
                <q-separator-- class="q-my-md"></q-separator-->
            </div>
        </q-card-section>
    </div>      
</template>

<script>// @ts-nocheck

import { mapState } from "vuex"
import { TagList, Title } from "@components/shared";
export default {
    name : "ConteudoMetadata",
    components: {TagList, Title},
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