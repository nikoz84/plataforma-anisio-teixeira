<template>
    <div class="q-mb-xl">
        <q-carousel
            swipeable
            animated
            v-model="name"
            controlType="flat"
            control-color="primary"
            navigation
            navigation-icon="radio_button_checked"
            infinite
            :autoplay="10000"
            arrows
            height="250px"
            class="rounded-borders bg-grey-5 text-white shadow-1"
            @input="changeSlide"
        >
            <q-carousel-slide name="null" class="column no-wrap flex-center" v-if="name === null">
                <q-icon name="style" size="56px" />
                <div class="q-mt-md text-center">
                    HOLA MUDNO
                </div>
            </q-carousel-slide>
            <q-carousel-slide 
                v-for="(slide, d) in slider"
                :key="`${d}-slide`"
                :name="slide.filename" 
                :img-src="slide.image">
            </q-carousel-slide>
            
        </q-carousel>
        <transition name="fade" mode="out-in">
            <q-card class="featured" v-show="showTitle" flat>
                <q-card-section class="text-right bg-blue-grey-1 color-grey-9" @click="goTo(activeSlide.url)">
                     SAIBA MAIS
                </q-card-section>
            </q-card>
        </transition>
        <q-separator ></q-separator>
    </div>
</template>
<script>
export default {
    name: "CarouselHome",
    data(){
        return {
            name: null, 
            slider: [],
            showTitle: false,
            activeSlide: {},
            isLoading: false
        }
    },
    mounted(){
        this.getSlider();
    },
    methods: {
        async getSlider(){
            this.isLoading = true
            const { data } = await axios.get('/options/slider');
            this.isLoading = false
            this.slider = data.options.meta_data;
            if(this.slider.length > 0){
                let showSlide = this.slider[0];
                this.name = showSlide.filename;
                this.activeSlide = this.slider[0];
                this.showTitle = true;
            }
            
        },
        changeSlide(v) {
            this.showTitle= false
            this.slider.forEach((value, i) => {
                if(value.filename === v) {
                    this.activeSlide = value;
                    this.showTitle= true
                }
            });
            
        },
        goTo(url) {
            window.location.href= url
        }
    }
}
</script>
<style lang="stylus" scoped>
.q-carousel__slide{
  width: 100% !important;
  height : 25vh !important;
}
.featured {
  font-family: Ubuntu, Arial;
  font-size: 16px;
  letter-spacing: 0.5px;
  word-spacing: 0.3px;
  font-weight: 700;
  cursor: pointer;
  font-style: italic;
  font-variant: small-caps;
  text-transform: uppercase;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>