<template>
    <div>
        <transition  name="custom-classes-transition" 
            enter-active-class="animated shake" 
            leave-active-class="animated fadeOut">
            <div v-if="isError" class="alert alert-info" role="alert" v-text="textAlert"></div>
        </transition>
    </div>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "AlertSheke",
  computed: {
    ...mapState(["isError", "textAlert"])
  }
};
</script>
