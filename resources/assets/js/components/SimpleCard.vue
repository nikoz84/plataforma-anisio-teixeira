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
                          class="img-responsive card-img-show" 
                          style="min-height: 35vh;"
                          :src="getImage">
                      <a class="tipo-btn"> {{ getTipo }}</a>

                    <!--/router-link-->
                  </div>
                  <div class="col-md-8">
                      <div class="card-row card-header card-heading-bottom">
                        <router-link  :to="{ name: 'ExibirConteudo', params: { slug: slug, id: item.id, action: 'exibir'}}"
                          aria-label="Título" 
                          v-bind:title="'Título: ' + title">
                          <h3 class="card-title card-heading-inner" 
                            :style="`border-bottom: 2px solid ${color}`"
                            v-html="title">
                          </h3>
                        </router-link>
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
    },
    getTipo() {
      return this.item.tipo ? this.item.tipo.name : this.item.category.name;
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
  background-color: rgb(4, 9, 30);
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
.card-link {
  text-decoration: none;
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

.tipo-btn {
  position: absolute;
  bottom: 0px;
  right: 0px;
  border-top-left-radius: 10px;
  padding: 15px 30px;
  background-color: #fff;
  -webkit-box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  -moz-box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  box-shadow: -19px -15px 17px -11px rgba(0, 0, 0, 0.4);
  color: rgb(4, 9, 30);
  text-transform: uppercase;
  font-size: 11px;
  font-weight: bolder;
  display: inline-block;
}
</style>
