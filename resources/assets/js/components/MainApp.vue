<template>
    <main>
        <nav-app></nav-app>
        <router-view class="container-fluid heigth"></router-view>
        <footer-app></footer-app>
    </main>
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
<style lang="scss" >
.heigth {
    min-height: 80vh;
}
</style>
