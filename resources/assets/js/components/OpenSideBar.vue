<template>
    <span @click="openSidebar()" class="btn btn-default afix" data-spy="affix" data-offset-bottom="50%">
        <i class="glyphicon glyphicon-search"></i>
    </span>
</template>
<script>
export default {
    name: "OpenSideBar",
    methods: {
        openSidebar() {
        document.getElementById("sidebar-home").style.width = "50%";
        },
    }
}
</script>
<style lang="scss" scoped>
.affix {
  background-color: rgb(1,14,27);
  background-color: rgba(1, 14, 27, .7);
  opacity: .8;
  border:none;
  width: 45px;
  height: 45px;
  left: 10px;
  bottom: 80%;
  border-radius: 2px;
  z-index: 100 !important;
  .glyphicon {
    color: white;
    font-size: 20px;
  }
}
</style>