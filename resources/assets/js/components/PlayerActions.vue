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
                v-if="conteudo.arquivos && conteudo.arquivos.download.url"
                @click="download(
                    'download', 
                    conteudo.id, 
                    conteudo.arquivos.download.mime_type)" >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn>
            <q-btn round color="secondary" icon="save_alt" size="sm"
                v-if="conteudo.arquivos && conteudo.arquivos.visualizacao.url"
                @click="download(
                    'visualizacao', 
                    conteudo.id, 
                    conteudo.arquivos.visualizacao.mime_type)" 
                    >
                <q-tooltip content-class="bg-grey-10" content-style="font-size: 12px">
                    Baixar conteúdo
                </q-tooltip>
            </q-btn>
            <q-btn round color="secondary" icon="description" size="sm"
                v-if="conteudo.arquivos && conteudo.arquivos.guia.url" 
                @click="download('guia', conteudo.id, conteudo.arquivos.guia.mime_type)" >
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
    computed: {
        ...mapState(["conteudo"])
    },
    methods: {
        async download(action, id, mimeType) {
            console.log(action, id)
            console.log(mimeType);
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
    },
}
</script>

<style>

</style>