<template>
    <div>
      <h3>Carregando...</h3> 
      <div class="load-bar">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>
    </div>
</template>
<script>
export default {
    name: 'Loader'
}
</script>
<style lang="scss" scoped>
.load-bar {
  position: relative;
  margin-top: 20px;
  width: 100%;
  height: 6px;
  background-color: #fdba2c;
}
.bar {
  content: "";
  display: inline;
  position: absolute;
  width: 0;
  height: 100%;
  left: 50%;
  text-align: center;
}
.bar:nth-child(1) {
  background-color: #0071bc;
  animation: loading 2s linear;
}
.bar:nth-child(2) {
  background-color: #0071bc;
  animation: loading 2s linear 1s infinite;
}
.bar:nth-child(3) {
  background-color: #f4b135;
  animation: loading 2s linear  1s infinite;
}
.bar:nth-child(3) {
  background-color: #009245;
  animation: loading 2s linear 2s ;
}
@keyframes loading {
    from {left: 50%; width: 0;z-index:100;}
    33.3333% {left: 0; width: 100%;z-index: 10;}
    to {left: 0; width: 100%;}
}
</style>


