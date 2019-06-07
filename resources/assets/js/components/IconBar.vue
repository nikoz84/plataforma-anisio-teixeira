<template>
  <div class="icon-bar afix" data-spy="affix" data-offset-bottom="50%">
    <a @click.prevent="openSidebar()" 
      class="">
        <i class="glyphicon glyphicon-search"></i>
    </a>
  </div>
</template>
<script>
export default {
  name: "OpenSideBar",
  methods: {
    openSidebar() {
      document.getElementById("sidebar-home").style.width = "100%";
    }
  }
};
</script>
<style lang="scss" scoped>
.icon-bar {
  width: 50px;
  background-color: #010e1b;
  background-color: rgba(1, 14, 27, 0.7);
  opacity: 0.8;
  z-index: 200 !important;
}

.icon-bar a {
  display: block;
  text-align: center;
  cursor: pointer;
  padding: 5px;
  transition: all 0.3s ease;
  color: white;
  font-size: 24px;
  .glyphicon {
    color: white;
    font-size: 20px;
  }
}

.icon-bar a:hover {
  background-color: #2196f3;
}

.affix {
  top: 14vh;
  right: 10px;
}
</style>