<template>
    <div v-if="conteudo">
        <div class="flex justify-center q-gutter-sm">
            <p v-if="conteudo.tipo">
                Tipo de Conteúdo: 
                <q-badge class="bg-grey-10" text-color="white">{{conteudo.tipo.name}}</q-badge>
            </p>
            <p v-if="conteudo.qt_access">
                Acessos: 
                <q-badge class="bg-grey-10" text-color="white">{{conteudo.qt_access}}</q-badge>
            </p>
            <p v-if="conteudo.qt_downloads && conteudo.tipo.id != 8">
                Downloads: 
                <q-badge class="bg-grey-10" text-color="white">{{conteudo.qt_downloads}}</q-badge>
            </p>
            <q-space></q-space>
            <ThumbsMenu></ThumbsMenu>
            <q-btn class="bg-grey-10" 
                text-color="white"
                icon="share"
                size="xs"
                @click="show = !show" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Compartilhar
                </q-tooltip>
            </q-btn>
            <q-btn
                class="bg-grey-10"
                text-color="white"
                icon="save_alt"
                size="xs"
                v-if="fileExists('download') && conteudo.id"
                @click="downloadFile('download', conteudo.id)" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn>
            <!--q-btn
                round
                push
                class="bg-grey-10"
                text-color="white"
                icon="save_alt"
                size="sm"
                v-if="fileExists('visualizacao')"
                @click="downloadFile('visualizacao', conteudo.id)" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn-->
            <q-btn
                class="bg-grey-10"
                text-color="white"
                icon="description"
                size="xs"
                v-if="fileExists('guias-pedagogicos')" 
                @click="downloadFile('guias-pedagogicos', conteudo.id)">
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar guia pedagógico
                </q-tooltip>
            </q-btn>
        </div>
        <div class="q-mt-md" v-if="show">
            <q-btn @click="incorporar" color="pink" label="Incorporar"></q-btn>

            <q-separator></q-separator>
            <q-input v-if="stringShare" v-model="stringShare" 
                hint="Copie e cole esse código para adicionar na sua página web" 
                autogrow readonly />
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";
import { Dialog } from "quasar";
import { DialogShare, ThumbsMenu } from "@components/shared";

export default {
    name : "PlayerActions",
    components: { ThumbsMenu },
    data() {
        return {
            guia : {},
            download: {},
            visualizacao: {},
            urlShare: null,
            stringShare: '',
            show: false,
            loading: false
        }
    },
    computed: {
        ...mapState(["conteudo"]),
        
    },
    methods: {
        async downloadFile(directory, id) {
            
            const file = this.conteudo.arquivos[directory];
            axios({ 
                url:`/files/${directory}/${id}`,  
                method : "GET",
                responseType: "blob"
                })
                .then(response => {
                
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', file.name);
                document.body.appendChild(link);
                link.click();
            })
            
        },
        incorporar() {
            const id = this.conteudo.id
            const port = location.port ? `:${location.port}` : '';
            const url = 'http://' + location.hostname + `${port}` + `/incorporar-conteudo/${id}`;
            this.stringShare = `
                <iframe width="560" height="315" src="${url}"
                        frameborder="0" 
                        allowfullscreen>
                </iframe>
            `;
            
        },
        fileExists(path) {
            let files = this.conteudo ? this.conteudo.arquivos : null;
            
            if(path && files != null){
                return files[`${path}`].hasOwnProperty('url');
            }
            return false
        }
    },
}
</script>

<style>

</style>