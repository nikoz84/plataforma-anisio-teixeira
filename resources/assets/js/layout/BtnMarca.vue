<template>
  <div class="row justify-center q-my-lg">
    <div style="width: 200px;height: 44px;fill: currentColor;">
      <svg class="icon-pat" height="38" width="200" style="color:white;">
        <use v-bind="{'xlink:href':'#logo'}"></use> 
      </svg>
    </div>
  </div>
</template>
<script>
export default {
  name: "BtnMarca"
};
</script>
