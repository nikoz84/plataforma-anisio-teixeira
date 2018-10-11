<template>
    <div>
        <nav-app></nav-app>
        <main class="container-fluid">
            <router-view ></router-view>
        </main>
        <footer-app></footer-app>
    </div>
</template>

<script>
import NavApp from './NavComponent.vue';
import FooterApp from './FooterComponent.vue';

export default {
    name : 'main-app',
    components:{
        NavApp, FooterApp
    },

}
</script>