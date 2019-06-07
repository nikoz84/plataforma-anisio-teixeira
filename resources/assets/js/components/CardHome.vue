<template>
<div>
  <header class="row justify-content-center heading-section" 
         style="padding-bottom: 1rem !important;margin-bottom: 3rem !important;">
    <h2 class="text-center" style="margin-bottom: 1.5rem !important;"
        v-text="title"></h2>
  </header>
    <div class="row">
      <article class="col-sm col-md-6 col-lg-4" v-for="(item, i) in items" :key="i">
        <figure class="card-container retina">
          <img v-lazy="item.image" class="img-responsive">
          <caption class="card-content" :style="isDestaque(i)">
            <a :href="item.url_exibir">
              <h2>{{ item.title ? item.title : item.name }}</h2>
            </a>
          </caption>
        </figure>
      </article>
    </div>
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
$primary: rgba(59, 9, 103, 0.7);
$white: rgba(255, 255, 130, 1);
// HEADING HOME
.heading-section {
  .subheading {
    font-size: 14px;
    display: block;
    margin-bottom: 10px;
  }
  h2 {
    font-size: 38px;
    font-weight: 400;
    position: relative;
    strong {
      font-weight: 700;
    }
    @media only screen and (max-width: 700px) {
      font-size: 25px;
    }
    &:after,
    &:before {
      width: 100px;
      height: 2px;
      position: absolute;
      bottom: -15px;
      left: 0;
      right: 0;
      margin: 0 auto;
      background: $primary;
      content: "";
    }
    &:before {
      width: 80px;
      height: 2px;
      bottom: -19px;
    }
  }
  &.heading-section-white {
    .subheading {
      color: rgba(255, 255, 255, 0.9);
    }
    h2 {
      font-size: 38px;
      color: $white;
      &:after,
      &:before {
        display: none;
      }
    }
    p {
      color: rgba(255, 255, 255, 0.9);
    }
  }
  &.heading-section-wo-line {
    h2 {
      &:after,
      &:before {
        display: none;
      }
    }
  }
}
.card-container {
  position: relative;
  display: table;
  margin: 0 auto;
  -webkit-box-shadow: -4px 7px 5px rgba(50, 50, 50, 0.77);
  -moz-box-shadow: -4px 7px 5px rgba(50, 50, 50, 0.77);
  box-shadow: -4px 7px 5px rgba(50, 50, 50, 0.77);
  max-height: 50vh;
  overflow: hidden;
}

.card-container > .card-content {
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0);
  background-color: rgba(59, 9, 103, 0.7);
  width: 100%;
  padding: 10px;
  a {
    text-decoration: none;
    z-index: 2;
  }
  > a h2 {
    font-size: 3vh;
    color: #fff;
  }
}
img {
  -webkit-transition: all 0.8s;
  -moz-transition: all 0.8s;
  -ms-transition: all 0.8s;
  -o-transition: all 0.8s;
  transition: all 0.8s;
}
.card-container:hover > img {
  -webkit-transform: scale(1.5);
  -moz-transform: scale(1.5);
  -ms-transform: scale(1.5);
  -o-transform: scale(1.5);
  transform: scale(1.5);
}
.card-container .retina {
  position: absolute;
  top: 0;
  left: 0;
  background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);
  text-align: left;
  z-index: 1;
  -webkit-transition: all 0.8s;
  -moz-transition: all 0.8s;
  -ms-transition: all 0.8s;
  -o-transition: all 0.8s;
  transition: all 0.8s;
}
.card-container:hover .retina {
  box-shadow: inset 0 0 100px 50px rgba(0, 0, 0, 0.5);
}
</style>