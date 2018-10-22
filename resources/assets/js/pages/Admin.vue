<template>
    <div class="container-fluid heigth">
        <Sidebar class="col-sm-3" ></Sidebar>
        <section class="col-sm-9">
            <Search v-bind:search="search"></Search>
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
            </header>
            <transition name="fade">
                <List v-if="show" v-bind:items="paginator.data"></List>
            </transition>
            <Paginator v-bind:paginator="paginator"></Paginator>
        </section>
    </div>
</template>
<script>
import Sidebar from '../components/SidebarComponent.vue';
import Search from '../components/SearchComponent.vue';
import List from '../components/ListComponent.vue';
import Paginator from '../components/PaginatorComponent.vue';

export default {
    name : 'admin',
    components:{
        Sidebar, Search, List, Paginator
    },
    data() {
        return {
            title: '',
            paginator: {},
            search: '',
            show: false
        }
    },
    methods:{

    }
}
</script>
<style lang="scss" scoped>

.page-header > h1 { margin-top: 0px; font-size: 20px;}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>

