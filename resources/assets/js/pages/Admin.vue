<template>
    <div class="container-fluid heigth">
        <Sidebar class="col-sm-3" ></Sidebar>
        <section class="col-sm-9">
            <Search v-bind:search="search"></Search>
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
            </header>
            <transition name="custom-classes-transition" 
                     enter-active-class="animated fadeInUp" 
                     leave-active-class="animated bounceOut"
                     mode="out-in">
                <div v-if="show">
                    <List v-bind:items="paginator.data"></List>
                    <Paginator v-bind:paginator="paginator"></Paginator>    
                </div>    
            </transition>
            
        </section>
    </div>
</template>
<script>
import Sidebar from '../components/SidebarComponent.vue';
import Search from '../components/SearchComponent.vue';
import List from '../components/ListComponent.vue';
import Paginator from '../components/PaginatorComponent.vue';
import store from '../store.js';

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
.page-header > h1 { margin-top: 0px; }
</style>

