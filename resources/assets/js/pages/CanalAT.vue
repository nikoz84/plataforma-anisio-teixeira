<template>
<section class="q-pa-xs q-pb-lg">
    <div v-if="canal">
        <img style="width:100%" :src="image" alt="Banner Canal">
        <q-separator></q-separator>
        
        
        <article class="q-pa-lg row justify-center text-justify ">
            <div id="paragraph" class="col-md-9" v-html="canal.document.description"></div>
        </article>
        
        <article class="q-pa-lg flex justify-center text-justify">
            <div class="padlet-embed" 
                style="overflow:hidden;position:relative;
                    width:100%;background:#F4F4F4">
                <p style="padding:0;margin:0">
                    <iframe loading="lazy" src="https://padlet.com/embed/2dd8zchhneh80cnr" frameborder="0" allow="camera;microphone;geolocation" style="width:100%;height:608px;display:block;padding:0;margin:0"></iframe>
                </p>
                <!--div style="padding:8px;text-align:right;margin:0;">
                    <a href="https://padlet.com?ref=embed" style="padding:0;margin:0;border:none;display:block;line-height:1;height:16px" target="_blank">
                    <img src="https://padlet.net/embeds/made_with_padlet.png" width="86" height="16" style="padding:0;margin:0;background:none;border:none;display:inline;box-shadow:none" alt="Criado com o Padlet"></a>
                </div-->
            </div>
        </article>
        
        <div class="row justify-center" style="margin-top:150px;">
            <article class="col-xs-12 col-md-5 q-mr-md">
                <q-btn stack to="/recursos-educacionais/listar?busca=podcast_at"
                :aria-label="canal.document.sections.podcast.label"
                type="a" target="__blank" 
                padding="none"
                >
                    <img width="100%" :src="canal.document.sections.podcast.img">
                </q-btn>
                        
            </article>
            <article class="col-xs-12 col-md-5">
                <q-btn stack to="/recursos-educacionais/conteudo/exibir/4900"
                :aria-label="canal.document.sections.cordelito.label"
                type="a" target="__blank"
                padding="none"
                >
                <img width="100%" :src="canal.document.sections.cordelito.img">
                </q-btn>
            </article>
        </div>
        
        <div class="q-pa-lg flex justify-center" style="margin-top:100px;">
            <div class="col-lg-8">
                <q-btn size="22px" icon="east" color="accent" type="a" target="__blank"
                    label="Veja mais conteúdos sobre Anísio Teixeira" 
                    to="/recursos-educacionais/listar?busca=canal_at"></q-btn>
            </div>
        </div>



        <q-tabs
            :style="`background-color:#333`" 
            class="text-white shadow-3"
            no-caps
            ripple
            dense
            inline-label
        >
        
        
        <q-route-tab
            name="listar"
            label="LISTAR"
            icon="view_list"
            :to="'/canal-anisio-teixeira/'"
        />
        <q-route-tab
            name="busca"
            label="BUSCA AVANÇADA"
            icon="search"
            :to="{ name: 'BuscaAvancada' }"
        />
        <q-route-tab
            name="inicio"
            label="SOBRE"
            icon="info"
            :to="'/canal-anisio-teixeira/sobre'"
        />
    </q-tabs>

    </div>
    
</section>
</template>

<script>
// @ts-nocheck
import { QMediaPlayer} from "@quasar/quasar-ui-qmediaplayer";
export default {
    name: "CanalAT",
    components:{QMediaPlayer},
    data() {
        return {
            podcasts: [],
            conteudos: [],
            canal : {
                name: null,
                document: {
                    title: '',
                    banner: '',
                    description: '',
                    sections: {
                        podcast: {
                            label: '',
                            img: ''
                        },
                        cordelito: {
                            label: '',
                            img: ''
                        },
                        conteudos: {
                            label: '',
                            image: ''
                        }
                    }
                }
            }
        }
    },
    computed: {
        image(){
            if(!this.canal.document.banner){
                return '/img/fundo-padrao.svg'
            }
            
            return this.canal.document.banner;
        }
    },
    mounted() {
        //this.SET_OPENSIDEBAR(true);
        this.getCanal()
        this.getPodcast()
    },
    methods: {
        async getCanal(){
            const {data} = await axios.get('/canal-at');
            this.canal = data.metadata
        },

        async getPodcast(){
            const {data} = await axios.get('/canal-at/podcast/');
            this.podcasts = data.metadata
            //console.log(this.podcasts)
        }
    },
}
</script>

<style>

#paragraph p{
    line-height: 1.5 !important;
    font-size: 16px;
    letter-spacing: 0.3px !important;
    word-spacing: 2px !important;
}

#paragraph p:first-child::first-letter {
    color:#FE5F55 !important;
    font-weight: bold !important;
    font-size: 70px !important;
    float: left !important;
    line-height: 60px !important;
    padding-right: 8px !important;
    margin-top: -3px !important;
}
.section{
  padding-top: 7.5rem;
  padding-bottom: 8.125rem;
}

</style>