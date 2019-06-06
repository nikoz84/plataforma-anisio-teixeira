<template>
    <div class="container-fluid heigth">
        <sidebar-admin class="col-sm-3" ></sidebar-admin>
        <section class="col-sm-9">
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
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
    "sidebar-admin": SidebarAdmin
  },
  data() {
    return {
      title: "Administração da Plataforma",
      search: "",
      show: false,
      slug: "",
      action: ""
    };
  },
  computed: {}
};
</script>
<style lang="scss" scoped>
.page-header > h1 {
  margin-top: 0px;
}
</style>

