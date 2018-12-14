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
.break-word { word-wrap: break-word; }
.tag{
    margin-right: 10px;
    margin-bottom: 5px;
}
.label{
    padding: 6px;
    margin-right: 15px;
    margin-bottom: 10px;
}

hr.line {
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #949da5, #ccc);
}
</style>
