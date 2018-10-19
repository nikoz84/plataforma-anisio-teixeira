<template>
    <div>
        <Sidebar class="col-sm-3" ></Sidebar>
        <section class="col-sm-9">
            <Search v-bind:search="search"></Search>
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
            </header>
            <List v-bind:items="paginator.data"></List>
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
            search: ''
        }
    },
    methods:{

    }
}
</script>
<style lang="sass" scoped>
.page-header { margin-top: 15px; }
.page-header > h1 { margin-top: 0px; font-size: 5vh;}

</style>

