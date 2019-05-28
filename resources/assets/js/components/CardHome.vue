<template>
    <div class="row">
        <div class="">
            <h2>{{ title }}</h2>
            <article v-for="(item, i) in items" :key="i">
                <div :class="isDestaque(i)">
                    <img v-lazy="item.image" class="img-responsive">
                    <div class="retina">
                        <div class="texto">
                          {{ (item.title) ? item.title : item.name }}
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>
<script>
export default {
  name: "CardHome",
  props: ["title", "items"],
  methods: {
    isDestaque(index) {
      return index == 0
        ? "col-md-5 destaque-principal"
        : "col-md-3 destaque-secundario ml-30";
    }
  }
};
</script>
<style>
.destaque-principal {
  overflow: hidden;
  float: left;
  margin: 0;
  border-radius: 5px;
}

ul {
  list-style-type: none;
}
.destaque-principal > img {
  width: 100%;
  height: 500px;
  border-radius: 5px;
  -webkit-transition: all 0.8s;
  -moz-transition: all 0.8s;
  -ms-transition: all 0.8s;
  -o-transition: all 0.8s;
  transition: all 0.8s;
}
.destaque-principal:hover > img {
  -webkit-transform: scale(1.5);
  -moz-transform: scale(1.5);
  -ms-transform: scale(1.5);
  -o-transform: scale(1.5);
  transform: scale(1.5);
}

.destaque-principal .retina {
  position: absolute;
  width: 100%;
  height: 100%;
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

.destaque-secundario {
  position: relative;
  overflow: hidden;
  border-radius: 5px;
  background: #fff;
  float: left;
  margin-left: 20px;
  margin-bottom: 20px;
}

.destaque-secundario > img {
  width: 100%;
  height: 240px;
  border-radius: 5px;
  -webkit-transition: all 0.8s;
  -moz-transition: all 0.8s;
  -ms-transition: all 0.8s;
  -o-transition: all 0.8s;
  transition: all 0.8s;
}
.destaque-secundario:hover > img {
  -webkit-transform: scale(1.5);
  -moz-transform: scale(1.5);
  -ms-transform: scale(1.5);
  -o-transform: scale(1.5);
  transform: scale(1.5);
}
.destaque-secundario .retina {
  position: absolute;
  width: 100%;
  height: 100%;
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
.destaque-secundario:hover .retina {
  box-shadow: inset 0 0 100px 50px rgba(0, 0, 0, 0.5);
}

.destaque-principal .texto {
  position: absolute;
  z-index: 2;
  margin-top: 75%;
  color: #fff;
  font-size: 16px;
  text-align: left;
  margin-left: 5px;
  padding: 10px;
  font-weight: bold;
  background-color: rgba(59, 9, 103, 0.7);
}

.destaque-secundario .texto {
  position: absolute;
  z-index: 2;
  margin-top: 35%;
  color: #fff;
  font-size: 16px;
  text-align: left;
  margin-left: 5px;
  padding: 10px;
  font-weight: bold;
  background-color: rgba(9, 67, 103, 0.7);
}

.col-md-5,
.col-md-3 {
  padding-right: 0px;
  padding-left: 0px;
}
</style>