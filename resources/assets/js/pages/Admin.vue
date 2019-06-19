<template>
  <div class="container-fluid heigth">
      <SidebarAdmin class="col-sm-3" ></SidebarAdmin>
      <section class="col-sm-9">
          <header class="page-header">
              <h1>{{ title }}</h1>
          </header>
          <router-view name="admin"></router-view>
      </section>
  </div>
</template>
<script>
import SidebarAdmin from "../components/SidebarAdmin.vue";
import { mapState } from "vuex";

export default {
  name: "admin",
  components: {
    SidebarAdmin
  },
  data() {
    return {
      title: "Administração da Plataforma"
    };
  },
  computed: {}
};
</script>
<style lang="scss" scoped>
.page-header {
  margin-top: 0px;
}
</style>

