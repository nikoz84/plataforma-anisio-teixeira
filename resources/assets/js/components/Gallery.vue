<template>
    <section>
        <header>
            <h2 class="text-capitalize text-center">
                {{title}}
            </h2>
        </header>
        <section class="gallery"> 
            <article class="column" v-for="(img, i) in images" :key="i">
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
.gallery {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}
.column {
  flex: 25%;
  padding: 0 4px;
}
.column img {
  margin-top: 8px;
  vertical-align: middle;
}
</style>
