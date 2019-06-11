<template>
    <section>
        <header>
            <h2 class="text-capitalize text-center">
                {{title}}
            </h2>
        </header>
        <section class="masonry bordered"> 
            <article class="brick" v-for="(img, i) in images" :key="i">
                <img v-lazy="img" :src="img" class="img-responsive"
                alt="">
                
            </article>
        </section>    
    </section>
    
</template>
<script>
export default {
  name: "Gallery",
  data() {
    return {
      images: [],
      title: ""
    };
  },
  created() {
    this.getImages();
  },
  methods: {
    async getImages() {
      await axios.get("/files/gallery").then(resp => {
        if (resp.data.success && resp.status == 200) {
          this.images = resp.data.metadata;
          this.title = resp.data.message;
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
/* Masonry grid */
.masonry {
  transition: all 0.5s ease-in-out;
  column-gap: 30px;
  padding-left: 30px;
  padding-right: 30px;
  column-fill: initial;
  .brick {
    margin-bottom: 30px;
    display: inline-block; /* Fix the misalignment of items */
    vertical-align: top; /* Keep the item on the very top */
  }
  .brick img {
    transition: all 0.5s ease-in-out;
    backface-visibility: hidden; /* Remove Image flickering on hover */
    &:hover {
      opacity: 0.75;
      cursor: pointer;
    }
  }
}

/* Bordered masonry */
.masonry.bordered {
  column-rule: 1px solid #eee;
  column-gap: 50px;
  .brick {
    padding-bottom: 25px;
    margin-bottom: 25px;
    border-bottom: 1px solid #eee;
  }
}

/* Gutterless masonry */
.masonry.gutterless {
  column-gap: 0;
  .brick {
    margin-bottom: 0;
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
  .desc {
    font-size: 1.25em;
  }

  .intro {
    letter-spacing: 1px;
  }

  .masonry {
    column-count: 3;
  }
}
</style>
