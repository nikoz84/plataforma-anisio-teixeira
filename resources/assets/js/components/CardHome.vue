<template>
  <div class="row">
    <header class="page-header">
      <h2 class="page-title" v-text="title"></h2>
    </header>
    <section>
      <article class="col-sm-6" v-for="(item, i) in items" :key="i">
        <figure class="card-container">
          <img v-lazy="item.image" :src="item.image">
          <caption class="card-content">
            <a :href="item.url_exibir">
              <h2>{{ item.title ? item.title : item.name }}</h2>
            </a>
          </caption>
        </figure>
      </article>
    </section>
</div>
</template>
<script>
export default {
  name: "CardHome",
  props: ["title", "items"],
  methods: {
    isDestaque(index) {}
  }
};
</script>
<style lang="scss" scoped>
$primary: #48246a;
$white: #f0f0f5;
$shadow: -2px 2px 2px #05182550;
$transition: all 0.8s;
$scale: scale(1.2);

.page-caption {
  padding-top: 170px;
  padding-bottom: 174px;
}
.page-title {
  font-size: 46px;
  line-height: 1;
  color: #fff;
  font-weight: 600;
  text-align: center;
}

.card-container {
  position: relative;
  display: table;
  padding: 0px;
  margin-bottom: 15px;
  overflow: hidden;
  -webkit-box-shadow: $shadow;
  -moz-box-shadow: $shadow;
  box-shadow: $shadow;
  img {
    -webkit-transition: $transition;
    -moz-transition: $transition;
    -ms-transition: $transition;
    -o-transition: $transition;
    transition: $transition;
    &:hover {
      -webkit-transform: $scale;
      -moz-transform: $scale;
      -ms-transform: $scale;
      -o-transform: $scale;
      transform: $scale;
    }
  }
  .card-content {
    box-shadow: inset 0 0 3px 2px rgba(0, 0, 0, 0.3);
    position: absolute;
    bottom: 0;
    padding-left: 10px;
    background: rgba(0, 0, 0, 0.877);
    background-color: $primary;
    width: 100%;
    a {
      text-decoration: none;
      z-index: 2;
    }
    > a h2 {
      margin-top: 7px;
      margin-bottom: 5.5px;
      font-weight: bolder;
      font-size: 2.2vh;
      color: #fff;
    }
  }
}

@media only screen and (min-width: 0px) and (max-width: 1023px) {
  .card-container img {
    width: 68vh;
    height: 35vh;
  }
}
@media only screen and (min-width: 1024px) {
  .card-container img {
    width: 70vh;
    height: 35vh;
  }
}
</style>