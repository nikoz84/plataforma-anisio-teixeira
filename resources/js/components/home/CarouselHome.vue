<template>
  <div class="q-mb-xl q-mt-lg ">
    <q-responsive :ratio="16 / 4" style="max-width: 100%;heigth:25vh">
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
        height="50vh"
        class="rounded-borders text-white shadow-2"
        @input="changeSlide"
      >
        <q-carousel-slide
          name="null"
          class="column no-wrap flex-center"
          v-if="name === null"
        >
        </q-carousel-slide>
        <q-carousel-slide
          v-for="(slide, d) in slider"
          :key="`${d}-slide`"
          :name="slide.filename"
          :img-src="slide.image"
          style="width:100%; heigth:50vh;"
        >
        </q-carousel-slide>
        <template v-slot:control>
          <q-carousel-control
            position="bottom"
            :offset="[16, 4]"
            class="text-left rounded-borders"
            style="padding: 10px 10px;"
          >
            <transition name="fade" mode="out-in">
              <q-btn
                color="accent"
                size="sm"
                class="text-left"
                @click="goTo(activeSlide.url)"
              >
                Saiba Mais
              </q-btn>
            </transition>
          </q-carousel-control>
        </template>
      </q-carousel>
    </q-responsive>
  </div>
</template>
<script>
export default {
  name: "CarouselHome",
  data() {
    return {
      name: null,
      slider: [],
      showTitle: false,
      activeSlide: {},
      isLoading: false,
    };
  },
  mounted() {
    this.getSlider();
  },
  methods: {
    async getSlider() {
      this.isLoading = true;
      const { data } = await axios.get("/options/slider");
      this.isLoading = false;
      this.slider = data.options.meta_data;
      if (this.slider.length > 0) {
        let showSlide = this.slider[0];
        this.name = showSlide.filename;
        this.activeSlide = this.slider[0];
        this.showTitle = true;
      }
    },
    changeSlide(v) {
      this.showTitle = false;
      this.slider.forEach((value, i) => {
        if (value.filename === v) {
          this.activeSlide = value;
          this.showTitle = true;
        }
      });
    },
    goTo(url) {
      window.location.href = url;
    },
  },
};
</script>
<style lang="stylus" scoped>

.q-carousel__slide{
  background-repeat:no-repeat;
  background-size:contain;
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
