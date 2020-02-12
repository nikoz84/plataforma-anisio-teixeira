<template>
  <router-view name="admin"></router-view>
</template>
<script>
import { mapState } from "vuex";
import Title from "../components/Title.vue";

export default {
  name: "admin"
};
</script>
