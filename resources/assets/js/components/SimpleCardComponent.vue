<template>
    <div>
        <article class="panel panel-default" v-bind:id="item.id" v-bind:style="'border-top-color:' + color">
            <div class="panel-heading">
                <figure class="figure">
                    <img class="img-responsive" 
                        v-lazy="getImage"
                        alt="imagem destacada"
                        srcset="">
                </figure>
            </div>
            <div class="panel-body">
                <router-link :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title">
                    <h4 class="text-center">{{ title }}</h4>
                </router-link>
                
            </div>
        </article>
    </div>
</template>
<script>
export default {
  name: "SimpleCard",
  props: {
    item: Object
  },
  computed: {
    title() {
      return this.item.name ? this.item.name : this.item.title;
    },
    slug() {
      return this.item.canal.slug;
    },
    color() {
      return this.item.canal ? this.item.canal.color : "#faf";
    },
    getImage() {
      return this.item.image;
    }
  },
  created() {}
};
</script>
<style lang="scss" scoped>
.panel-default {
  border-right-width: 1px;
  border-top-width: 7px;
}
.panel-default .panel-heading {
  padding: 2px 2px;
}
.figure .img-responsive {
  margin: 0 auto;
}
.img-responsive {
  width: 100%;
}
</style>
