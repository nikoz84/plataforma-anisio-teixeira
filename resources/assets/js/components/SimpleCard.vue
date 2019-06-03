<template>
    <div class="col-md-12">
       <article class="no-padding card-item" 
              data-category="view" 
              v-bind:id="item.id">
          <div class="card-panel">
              <div class="row box-shadow">
                  <div class="col-md-4">
                    <!--router-link  :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title"-->
                      <img v-lazy="getImage"
                          alt="imagem destacada" 
                          class="card-img-show" 
                          :src="getImage">
                      <a class="tipo-btn"> link</a>

                    <!--/router-link-->
                  </div>
                  <div class="col-md-8">
                      <div class="card-row card-header card-heading-bottom">
                        <h3 class="card-title card-heading-inner" :style="`border-bottom: 2px solid ${color}`">
                          <router-link  :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                            aria-label="Título" 
                            v-bind:title="'Título: ' + title">
                            {{ title }}
                          </router-link>
                        </h3>
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
      return this.item.canal ? this.item.canal.slug : this.item.slug;
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
  margin-bottom: 20px;
}
.card-panel img {
  width: 100%;
  max-height: 35vh;
  background-color: #a7a9ad;
}

.card-panel .row,
.card-panel .col-md-4 {
  padding: 0;
  background-color: #ffffff;
}

.card-panel .card-row {
  padding: 0 20px 0 20px;
}

.card-panel .card-row.card-header {
  background-color: #ffffff;
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
.card-heading-bottom .card-heading-inner {
  padding-bottom: 6px;
  border-bottom: 2px solid #2c87f0;
  position: relative;
  bottom: -1px;
}

.card-heading-inner {
  display: inline-block;
}

.card-panel .card-row.card-desc {
  position: relative;
  height: 100%;
  display: block;
  font-size: 16px;
}
.card-panel .card-row.card-desc a {
  position: absolute;
  width: 100%;
  bottom: 10px;
  left: 20px;
}

.row-margin-bottom {
  margin-bottom: 20px;
}

.box-shadow {
  -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
}

.no-padding {
  padding: 0;
}

.tipo-btn{
    position: absolute;
    bottom: -5px;
    border-top-right-radius: 10px;
    padding: 15px 30px;
    background-color: #fff;
    color: #ef1313;
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}
</style>
