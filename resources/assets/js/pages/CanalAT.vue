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
        
        <!--div class="row justify-center" style="margin-top:150px;">
            <article class="col-xs-12 col-md-5 q-mr-md">
                <img width="100%" :src="canal.document.sections.podcast.img" @click="goTo('podcast')">
            </article>
            <article class="col-xs-12 col-md-5">
                <img width="100%" :src="canal.document.sections.cordelito.img">
            </article>
        </div>

        <div class="q-pa-lg flex justify-center">
            <h2 class="text-h5">{{canal.document.sections.conteudos.label}}</h2>
        </div>
        
        <div-- class="flex justify-center" id="conteudos">
            <article  class="col-sm-3 dom-node-demo el" style="background-color:#ADFDFF">

            </article>
            
        </div-->
        <div class="q-pa-lg flex justify-center">
            <div class="col-lg-8">
                <img width="100%" :src="canal.document.sections.podcast.img" >
            </div>
        </div>

        <div class="q-pa-lg flex justify-center" v-if="podcasts && podcasts.length > 0">
            <div class="q-ma-md col-lg-5" v-for="(podcast, i) in podcasts" :key="i">
                <h4 class="text-h5">{{podcast.name}}</h4>
                <q-media-player type="audio"
                    :sources="[{
                        type: podcast.type,
                        src: podcast.src
                    }]"
                    dense
                    hide-volume-slider
                    poster=""
                    :volume="25"
                ></q-media-player>
            </div>
        </div>


        <div class="q-pa-lg flex justify-center">
            <div class="col-lg-8">
                <q-btn size="22px" icon="east" color="accent" label="Veja mais conteúdos sobre Anísio Teixeira" to="/recursos-educacionais/listar?busca=canal_at"></q-btn>
            </div>
        </div>

    </div>
    
</section>
</template>

<script>
// @ts-nocheck
import { QMediaPlayer} from "@quasar/quasar-ui-qmediaplayer";
import { mapMutations } from "vuex";
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
        this.SET_OPENSIDEBAR(true);
        this.getCanal()
        this.getPodcast()
    },
    methods: {
        ...mapMutations(['SET_OPENSIDEBAR']),
        async getCanal(){
            const {data} = await axios.get('/canal-at');
            this.canal = data.metadata
        },

        async getPodcast(){
            const {data} = await axios.get('/canal-at/podcast/');
            this.podcasts = data.metadata
            console.log(this.podcasts)
        },
        animateEffect(){
            var elements = document.querySelectorAll('.el');
            this.$anime({
                targets: elements,
                keyframes: [
                    {translateY: -40},
                    {translateX: 250},
                    {translateY: 40},
                    {translateX: 0},
                    {translateY: 0}
                ],
                duration: 4000,
                easing: 'easeOutElastic(1, .8)',
                loop: true
            });
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