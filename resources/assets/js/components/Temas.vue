<template>
    <nav role="menu temas transversáis" 
         v-if="temas"
         :style="'margin-top: 30px;'">
        <h5 class="text-center"
            :style="'margin-bottom: 20px;'">{{ temas.name }}</h5>
        <ul class="nav nav-pills nav-stacked">
            <li  v-for="(tema, t) in temas.components" :key="t">
                <router-link :to="{ name: 'Listar', 
                            params: { slug : $route.params.slug }, 
                            query: { categoria: $route.query.categoria, tema: tema.id }}" exact>
                <a>{{ tema.name }}</a>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
<script>
import {mapState} from 'vuex';

export default {
    name: "Temas",
    computed: {
        ...mapState(["temas"])
    },
}
</script>