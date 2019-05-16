<template>
    <div class="text-center alert-bottom alert"  
        :class="classAlert"
        v-if="this.showAlert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <b>{{ this.textAlert }}</b>
    </div>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "Alert",
  computed: {
    ...mapState(["showAlert", "textAlert", "isError"]),
    classAlert() {
      return this.isError ? "alert-success" : "alert-danger";
    }
  }
};
</script>
<style scoped>
.alert-bottom {
  position: fixed;
  z-index: 1300;
  bottom: 60px;
  left: 20%;
  width: 50%;
}
.alert-top {
  position: fixed;
  z-index: 1300;
  top: 60px;
  left: 20%;
  width: 50%;
}
</style>
