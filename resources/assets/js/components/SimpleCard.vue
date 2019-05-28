<template>
    <div class="col-md-12">
       <article class="no-padding card-item" 
              data-category="view" 
              v-bind:id="item.id">
          <div class="card-panel">
              <div class="row box-shadow">
                  <div class="col-md-4">
                    <router-link  :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title">
                      <img v-lazy="getImage"
                          alt="imagem destacada" 
                          class="card-img-show" 
                          :src="getImage">
                    </router-link>
                  </div>
                  <div class="col-md-8">
                      <div class="card-row card-header">
                        <h3 class="card-title">
                          <router-link  :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title">
                            {{ title }}
                          </router-link>
                        </h3>
                        <div class="card-header-seperator" v-bind:style="`background-color: ${color}`"></div>
                      </div>
                      <div class="card-row card-desc">
                        <p v-html="item.excerpt"></p>
                      </div>
                  </div>
              </div>
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
.card-panel {
    margin-bottom: 20Px;
}
.card-panel img {
    width: 100%;
    background-color: transparent;
}

.card-panel .row,
.card-panel .col-md-4 {
    padding: 0;
    background-color: #FFFFFF;
}


.card-panel .card-row {
    padding: 0 20px 0 20px;
}

.card-panel .card-row.card-header {
    background-color: #FFFFFF;
    font-size: 20px;
    padding: 10px 20px 0 20px;
}
.card-row .card-header.car-title {
  font-size: 20px;
}
.card-panel .card-row.card-header .card-header-seperator {
    height: 4px;
    width: 35%;
    background-color: #d9d9d9;
    margin: 7px 0 7px 0;
}

.card-panel .card-row.card-desc {
    position: relative;
    height: 100%;
    display: block;
    font-size: 16px;
}
.card-panel .card-row.card-desc a{
    position: absolute;
    width: 100%;
    bottom: 10px;
    left: 20px;
}

.row-margin-bottom {
    margin-bottom: 20px;
}

.box-shadow {
    -webkit-box-shadow: 0 0 10px 0 rgba(0,0,0,.10);
    box-shadow: 0 0 10px 0 rgba(0,0,0,.10);
}

.no-padding {
    padding: 0;
}
</style>
