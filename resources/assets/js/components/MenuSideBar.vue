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
