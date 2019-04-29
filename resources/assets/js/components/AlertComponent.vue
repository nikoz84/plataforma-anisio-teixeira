<template>
    <div class="text-center alert-top alert"  
        :class="[ (isError) ?  'alert-success' : 'alert-info']"
        v-if="showAlert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <b>{{ textAlert }}</b>
    </div>
</template>
<script>
export default {
  name: "Alert",
  methods: {},
  computed: {
    showAlert() {
      return this.$store.state.showAlert;
    },
    textAlert() {
      return this.$store.state.textAlert;
    },
    isError() {
      return this.$store.state.isError;
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
  left: 20%;
  width: 50%;
}
</style>
