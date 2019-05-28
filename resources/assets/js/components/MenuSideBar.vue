<template>
  <div>
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation" class="active">Canais</li>
      <router-link v-for="(link,i) in links"
              :key="i"
              tag="li"
              :to="{ name: 'Listar', params: {slug: link.slug}}">
          <a>{{link.name}}</a>
      </router-link>
    </ul>
  </div>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "MenuSideBar",
  computed: {
    ...mapState(["links"])
  }
};
</script>
<style lang="scss" scoped>
ul {
  margin: 5px;
}

li{
  border: 1px solid rgb(231, 230, 230);
  background-color: rgb(233, 233, 233);
}

.active{
  background-color: rgb(131, 133, 134);
  color:rgb(255, 255, 255);
  padding: 10px;
  font-weight: bold;
}

</style>