<template>
    <div>
            <q-carousel
                swipeable
                animated
                v-model="key"
                controlType="flat"
                control-color="primary"
                navigation
                navigation-icon="radio_button_checked"
                infinite
                :autoplay="10000"
                arrows
                height="250px"
                class="accent rounded-borders"
            >
                <q-carousel-slide style="background-size: contain; background-repeat: no-repeat;"
                :name="1"
                img-src="/storage/conteudos/slider/banner_ensinosuperior.png">
                <div class="absolute-bottom custom-caption">
                    <q-btn style="z-index: 10;" class="q-ma-md" round outline color="accent" icon="directions"></q-btn>
                </div>
                </q-carousel-slide>
                <q-carousel-slide style="background-size: contain; background-repeat: no-repeat;"
                :name="2" 
                img-src="/storage/conteudos/slider/banner_rotinas-de-estudo.png">
                <div class="absolute-bottom custom-caption">
                    <q-btn style="z-index: 10;" class="q-ma-md" round outline color="accent" icon="directions"></q-btn>
                </div>
                </q-carousel-slide>
                <q-carousel-slide 
                    v-for="(slide,i) in slider"
                    :key="i"
                    :name="`${i}-slide`" 
                    :img-src="slide.image">
                <div class="absolute-bottom custom-caption">
                    <q-btn style="z-index: 10; margin: 0 0 3px 3px;" round outline color="accent" icon="directions"></q-btn>
                </div>
                </q-carousel-slide>

            </q-carousel>
    </div>
</template>
<script>
export default {
    name: "CarouselHome",
    data(){
        return {
            key: 1, 
            slider: []
        }
    },
    created(){
        this.getSlider();
    },
    methods: {
        getSlider(){
            axios.get('/options/slider').then(({data})=>{
                this.slider = data.options.meta_data
                console.log(data.options.meta_data)
            })
        }
    }
}
</script>
<style lang="stylus" scoped>
.q-carousel__slide{
  width: 100% !important;
  height : 25vh !important;
}
</style>