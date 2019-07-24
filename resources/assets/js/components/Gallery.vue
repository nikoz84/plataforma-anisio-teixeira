<template>
    <section class="row">
        <header class="col-12">
            <h2 class="text-center" style="margin-bottom: 1.5rem !important;">
                {{title}}
            </h2>
        </header>
        <section class="col-12">
          <div class="masonry bordered">
            <article class="q-gutter-xs q-mt-xs img" v-for="(img, i) in images" :key="i">
                <q-img :src="img" :placeholder-img="'/img/fundo-padrao.svg'" alt="Imagem da galeria" @click="fullWidth = true"/>
            </article>
          </div>
        </section>
        
        <q-dialog v-model="fullWidth" full-width>
          <q-card dark class="bg-grey-9">
            <q-card-section>
              sdsdsdf
            </q-card-section>
    
            <q-card-actions align="right">
              <q-btn flat label="FECHAR" v-close-popup ></q-btn>
            </q-card-actions>
          </q-card>
        </q-dialog>
    </section>
    
</template>
<script>
import { QImg, QDialog, QCard, QCardSection, QCardActions } from "quasar";

export default {
  name: "Gallery",
  components: { QImg, QDialog, QCard, QCardSection, QCardActions },
  data() {
    return {
      images: [],
      title: "",
      fullWidth: true
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
    },
    openModal(img) {
      console.log(img);
      let message = `<img src="${img}"/>`;
    }
  }
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
