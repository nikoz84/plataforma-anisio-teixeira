<template>
    <q-card v-if="conteudo && conteudo.tipo && conteudo.qt_access && conteudo.qt_downloads">
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
            
            <q-btn class="q-ml-md" 
                round color="secondary" 
                icon="share" 
                size="sm" 
                @click="share()" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Compartilhar
                </q-tooltip>
            </q-btn>
            <q-btn round color="secondary" icon="save_alt" size="sm"
                v-if="fileExists('download')"
                @click="downloadFile('download')" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn>
            <q-btn round color="secondary" icon="save_alt" size="sm"
                v-if="fileExists('visualizacao')"
                @click="downloadFile('visualizacao')" 
                    >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn>
            <q-btn round color="secondary" icon="description" size="sm"
                v-if="fileExists('guia')" 
                @click="downloadFile('guia')"
                    >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar guia pedagógico
                </q-tooltip>
            </q-btn>
        </q-card-section>
    </q-card>
</template>

<script>
import {mapState} from "vuex";

export default {
    name : "PlayerActions",
    data() {
        return {
            guia : {},
            download: {},
            visualizacao: {}
        }
    },
    computed: {
        ...mapState(["conteudo"]),
        
    },
    methods: {
        async downloadFile(file) {
            console.log(file)
            console.log(this.guia)
            console.log(this.visualizacao)
            console.log(this.download)
            //console.log(action, id)
            //console.log(mimeType);
            /*
            axios({ url: `/files/${action}/${id}`,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'file.pdf');
                document.body.appendChild(fileLink);
                fileLink.click();
            });
            */
        },
        share() {
            console.log("compartilhar");
        },
        fileExists(path) {
            let files = this.conteudo.arquivos;
            let hasUrl = files[path].hasOwnProperty('url');
            console.log(files[path])
            switch (path) {
                case 'guia':
                    this.guia = hasUrl ? files[path] : {};
                    break;
                case 'download':
                    this.donwload = hasUrl ? files[path] : {};
                    break;
                case 'visualizacao':
                    this.visualizacao = hasUrl ? files[path] : {};
                    break;
                default:
                    return;
                    break;
            }

            return hasUrl ? true : false;
        }
    },
}
</script>

<style>

</style>