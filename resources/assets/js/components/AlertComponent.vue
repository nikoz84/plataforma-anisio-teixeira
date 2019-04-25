<template>
    <div class="alert-top alert alert-success" v-if="showAlert">
        <!--a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a-->
        {{ textAlert }}
    </div>
</template>
<script>
export default {
  name: "Alert",
  computed: {
    showAlert() {
      return this.$store.state.showAlert;
    },
    textAlert() {
      return this.$store.state.textAlert;
    }
  }
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
