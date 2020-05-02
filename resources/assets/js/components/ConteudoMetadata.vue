<template>
    <q-card class="q-mt-lg" v-if="conteudo">
        <q-card-section>
            <small>
                Tipo de Conteúdo: 
                <q-badge color="secondary">{{conteudo.tipo.name}}</q-badge>
            </small>
            <small>
                Acessos: 
                <q-badge color="secondary">{{conteudo.qt_access}}</q-badge>
            </small>
            <small v-if="conteudo.tipo.id != 8">
                Downloads: 
                <q-badge color="secondary">{{conteudo.qt_downloads}}</q-badge>
            </small>
            
            <q-btn class="q-ml-md" round color="secondary" icon="share" size="sm" @click="share()" ></q-btn>
            <q-btn round color="secondary" icon="save_alt" size="sm"
                v-if="conteudo.arquivos && conteudo.arquivos.download.url"
                @click="download('download', conteudo.id)" >
            </q-btn>
            <q-btn round color="secondary" icon="save_alt" size="sm"
                v-if="conteudo.arquivos && conteudo.arquivos.visualizacao.url"
                @click="download('visualizacao', conteudo.id)" >
            </q-btn>
            <q-btn round color="secondary" icon="description" size="sm"
                v-if="conteudo.arquivos && conteudo.arquivos.guia.url" 
                @click="download('guia', conteudo.id)" >
            </q-btn>
                
            <q-separator class="q-my-md"></q-separator>
            <strong>
                Publicador(a):
            </strong>
            <q-chip dense
                    color="blue-grey-6" 
                    text-color="white"
                    clickable
                    :label="conteudo.user.name"
                    @click="onClick(`/recursos-educacionais/listar?publicador=${conteudo.user.id}`)">
            </q-chip>
            
            <!--q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Outros conteúdos deste publicador
            </q-tooltip-->
            
            <q-separator class="q-my-md"></q-separator>

            <strong>Publicado em: </strong>
                {{conteudo.formated_date}}
                
            <q-separator class="q-my-md"></q-separator>
            
            <strong>Fonte:</strong>
                {{ conteudo.source }}

            <q-separator class="q-my-md"></q-separator>
            
            <strong>Autores:</strong>
                <i class="i-list break-word" 
                    v-for="(author,i) in splitAuthors" 
                    :key="`a-${i}`" 
                    v-text="author">
                </i>
            
            <q-separator class="q-my-md"></q-separator>
            
            <strong>Licença:</strong>
                {{conteudo.license.name}}

            <q-separator class="q-my-md"></q-separator>

            <strong >Componentes:</strong>
            <q-chip dense
                    color="blue-grey-6" 
                    text-color="white"
                    v-for="(componente) in conteudo.componentes"
                    :key="`c-${componente.id}`"
                    :label="componente.name"
                    clickable
                    @click="searchByComponents(componente.id)"
                >
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
        ...mapState(['conteudo']),
        splitAuthors() {
            if (this.conteudo.authors) {
                let replace = this.conteudo.authors.replace(",", ";");
                return replace.split(";");
            }
        },
        
    },
    methods: {
        searchByComponents(id) {
            let url = `/recursos-educacionais/listar?componentes=${id}`;
            this.$router.push(url);
        },
        download(action, id) {
            switch (action) {
                case "download":
                    
                break;
                case "guia":
                console.warn("guia");
                break;
            }
        },
        share() {
        console.log("compartilhar");
        },
        onClick(url) {
            this.$router.push(url);
        }
    },
}
</script>

<style lang="stylus" scoped>
i::before {
  content: " * ";
  padding-right: 5px;
  padding-left: 7px;
}
</style>