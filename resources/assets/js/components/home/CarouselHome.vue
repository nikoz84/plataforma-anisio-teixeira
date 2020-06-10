<template>
    <div>
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
            class="accent rounded-borders"
            @input="changeSlide"
        >
           <q-carousel-slide 
                v-for="(slide, d) in slider"
                :key="`${d}-slide`"
                :name="slide.filename" 
                :img-src="slide.image">
            </q-carousel-slide>
        </q-carousel>
        <transition name="fade" mode="out-in" tag="div">
            <q-card class="featured" v-show="showTitle" flat bordered>
                <q-card-actions @click="goTo(activeSlide.url)">
                    {{ activeSlide.title }}
                </q-card-actions>
            </q-card>
        </transition>
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
            activeSlide: {}
        }
    },
    mounted(){
        this.getSlider();
    },
    methods: {
        async getSlider(){
            const { data } = await axios.get('/options/slider');
            
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
            location.href= url
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
  font-size: 20px;
  letter-spacing: 0.6px;
  word-spacing: 0.4px;
  color: #1E6ED3;
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