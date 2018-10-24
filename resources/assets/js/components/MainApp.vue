<template>
    <main>
        <nav-app></nav-app>
        <router-view></router-view>
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
    methods: {
    
    }

}
</script>
<style lang="scss" >
body{ padding-top: 60px; }
.heigth { min-height: 80vh;}
.pointer { cursor: pointer;}

</style>
