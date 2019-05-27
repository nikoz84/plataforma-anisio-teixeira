<template>
    <span @click="openSidebar()" class="btn btn-default afix" data-spy="affix" data-offset-bottom="50%">
        <i class="glyphicon glyphicon-option-vertical"></i>
    </span>
</template>
<script>
export default {
    name: "OpenSideBar",
    methods: {
        openSidebar() {
        document.getElementById("sidebar-home").style.width = "50%";
        },
    }
}
</script>
<style lang="scss" scoped>
    
</style>