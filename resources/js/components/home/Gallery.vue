<template>
  <section class="q-ma-md">
    <header class="row text-h5">
      {{ title }}
    </header>
    <div class="masonry bordered">
      <article
        class="q-gutter-xs q-mt-xs img"
        v-for="(img, i) in images"
        :key="i"
      >
        <q-img
          :src="img"
          :placeholder-img="`/img/fundo-padrao.svg`"
          alt="Imagem da galeria"
          clickable
          @click="fullWidth = true"
        />
      </article>
    </div>
  </section>
</template>
<script>
export default {
  name: "Gallery",
  data() {
    return {
      images: [],
      title: "",
      fullWidth: true,
    };
  },
  created() {
    this.getImages();
  },
  methods: {
    async getImages() {
      await axios.get("/files/galeria").then((resp) => {
        if (resp.data.success && resp.status == 200) {
          this.images = resp.data.metadata;
          this.title = resp.data.message;
        }
      });
    },
    openModal(img) {
      console.log(img);
      let message = `<img src="${img}"/>`;
    },
  },
};
</script>
<style lang="stylus" scoped>
/* Bordered masonry */
.masonry.bordered {
  column-rule: 1px solid #eee;
  column-gap: 50px;

  .img {
    &:hover {
      opacity: 0.75;
      cursor: pointer;
    }
  }
}

/* Masonry on tablets */
@media only screen and (min-width: 768px) and (max-width: 1023px) {
  .masonry {
    column-count: 2;
  }
}

/* Masonry on big screens */
@media only screen and (min-width: 1024px) {
  .masonry {
    column-count: 3;
  }
}
</style>
