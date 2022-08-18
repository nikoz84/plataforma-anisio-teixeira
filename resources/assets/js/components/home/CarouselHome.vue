<template>
  <div class="q-mb-xl q-mt-lg">
    <q-carousel
      v-model="name"
      ref="carousel"
      swipeable
      animated
      controlType="push"
      control-color="dark"
      infinite
      :autoplay="5000"
      height="28vh"
      class="bg-primary text-white shadow-1"
      @input="changeSlide"
    >
      <q-carousel-slide name="null" class="" v-if="name === null">
      </q-carousel-slide>
      <q-carousel-slide
        v-for="(slide, d) in slider"
        :key="`${d}-slide`"
        :name="slide.filename"
        :img-src="slide.image"
        style=""
      >
      </q-carousel-slide>
      <template v-slot:control>
        <q-carousel-control
          position="bottom-right"
          :offset="[18, 18]"
          class="q-gutter-xs"
        >
          <q-btn
            push
            round
            dense
            color="dark"
            text-color="white"
            icon="arrow_left"
            @click="$refs.carousel.previous()"
          />
          <q-btn
            push
            round
            dense
            color="dark"
            text-color="white"
            icon="arrow_right"
            @click="$refs.carousel.next()"
          />
        </q-carousel-control>
        <q-carousel-control
          position="bottom-left"
          :offset="[18, 18]"
          class="text-left rounded-borders"
          style=""
        >
          <q-btn
            color="accent"
            size="sm"
            class="text-left"
            @click="goTo(activeSlide.url)"
          >
            Saiba Mais
          </q-btn>
        </q-carousel-control>
      </template>
    </q-carousel>
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
      slide: 1,
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
// .featured {
//   font-family: Ubuntu, Arial;
//   font-size: 16px;
//   letter-spacing: 0.5px;
//   word-spacing: 0.3px;
//   font-weight: 700;
//   cursor: pointer;
//   font-style: italic;
//   font-variant: small-caps;
//   text-transform: uppercase;
// }
// .fade-enter-active, .fade-leave-active {
//   transition: opacity .5s;
// }
// .fade-enter, .fade-leave-to {
//   opacity: 0;
// }

</style>
