<template>
    <ul class="nav nav-pills nav-stacked col-md-3">
        <li role="presentation" class="active"><a href="#">Canais</a></li>
        <router-link v-for="(link,i) in links"
                :key="i"
                tag="li"
                :to="{ name: 'Listar', params: {slug: link.slug}}">
            <a>{{link.name}}</a>
        </router-link>
    </ul>
</template>
<script>
import { mapState } from "vuex";

export default {
  name: "MenuSideBar",
  computed: {
    ...mapState(["isLogged", "links"])
  },
};
</script>
