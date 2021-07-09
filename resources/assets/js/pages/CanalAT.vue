<template>
<section class="q-pa-xs q-pb-lg">
    <div v-if="canal">
        <img style="width:100%" :src="image" alt="Banner Canal">
        <q-separator></q-separator>
        
        
        <article class="q-pa-lg row justify-center text-justify">
            <div class="col-md-10" v-html="canal.document.description"></div>
        </article>
        
        <article class="q-pa-lg flex justify-center text-justify">
            <div class="padlet-embed" 
                style="overflow:hidden;position:relative;
                    width:100%;background:#F4F4F4">
                <p style="padding:0;margin:0">
                    <iframe src="https://padlet.com/embed/2dd8zchhneh80cnr" frameborder="0" allow="camera;microphone;geolocation" style="width:100%;height:608px;display:block;padding:0;margin:0"></iframe>
                </p>
                <!--div style="padding:8px;text-align:right;margin:0;">
                    <a href="https://padlet.com?ref=embed" style="padding:0;margin:0;border:none;display:block;line-height:1;height:16px" target="_blank">
                    <img src="https://padlet.net/embeds/made_with_padlet.png" width="86" height="16" style="padding:0;margin:0;background:none;border:none;display:inline;box-shadow:none" alt="Criado com o Padlet"></a>
                </div-->
            </div>
        </article>
        
        <div class="row justify-center" style="margin-top:150px;">
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
        
        <div class="flex justify-center" id="conteudos">
            <article  class="col-sm-3 dom-node-demo el" style="background-color:#ADFDFF">
                
            </article>
        </div>

    </div>
    
</section>
</template>

<script>
// @ts-nocheck
import { mapMutations } from "vuex";
export default {
    name: "CanalAT",
    data() {
        return {
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
    },
    methods: {
        ...mapMutations(['SET_OPENSIDEBAR']),
        async getCanal(){
            const {data} = await axios.get('/canal-at');
            this.canal = data.metadata
        },

        goTo(data){
            console.log(data)
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

<style scoped>
article p{
  font-size: 16px;
  line-height: 1.4;
}

.section{
  padding-top: 7.5rem;
  padding-bottom: 8.125rem;
}

</style>