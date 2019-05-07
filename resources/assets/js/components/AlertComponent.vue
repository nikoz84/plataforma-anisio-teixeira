<template>
    <div class="text-center alert-bottom alert"  
        :class="classAlert"
        v-if="this.showAlert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <b>{{ this.textAlert }}</b>
    </div>
</template>
<script>
import {mapGetters, mapState} from 'vuex';

export default {
  name: "Alert",
  computed: {
    ...mapGetters({
      textAlert: 'getTextAlert',
      isError: 'getIsError'
    }),
    ...mapState([
      'showAlert'
    ]),
    classAlert(){
      return (this.isError) ? 'alert-warning': 'alert-success';
    }
  }
};
</script>
<style scoped>
.alert-bottom {
  position: fixed;
  z-index: 1300;
  bottom: 5px;
  left: 2%;
  width: 96%;
}
.alert-top {
  position: fixed;
  z-index: 1300;
  top: 60px;
  left: 20%;
  width: 50%;
}
</style>
