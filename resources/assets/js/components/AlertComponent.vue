<template>
    <div class="alert-top alert alert-success" v-if="isError">
        <!--a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a-->
        {{ text }}
    </div>
</template>
<script>
export default {
  name: "Alert",
  props: ["isError", "text"]
};
</script>
<style scoped>
.alert-bottom {
  position: fixed;
  bottom: 5px;
  left: 2%;
  width: 96%;
}
.alert-top {
  position: fixed;
  top: 60px;
  left: 2%;
  width: 96%;
}
</style>
