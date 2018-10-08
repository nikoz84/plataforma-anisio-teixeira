<template>
    <nav>
          <router-link to="/">Inicio</router-link> |
          <router-link to="/admin">Administração</router-link> |
          <router-link :to="{ name: 'Inicio', params: {slug: 'tv-anisio-teixeira'}}">Tv Anísio Teixeira</router-link> |
          <router-link :to="{ name: 'Inicio', params: {slug: 'radio-anisio-teixeira'}}">Radio Anísio Teixeira</router-link> |
          <router-link :to="{ name: 'Inicio', params: {slug: 'emitec'}}">Emitec</router-link> |
          <router-link :to="{ name: 'Inicio', params: {slug: 'projetos-artisticos'}}">Projetos Artisticos</router-link> |
          <router-link :to="{ name: 'Inicio', params: {slug: 'sites-tematicos'}}">Sites Temáticos</router-link>
    </nav>
</template>

<script>
    export default {
        name : 'nav-app',
        mounted() {
        
        }    
    }
</script>
