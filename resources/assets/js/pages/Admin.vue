<template>
    <div class="container-fluid heigth">
        <Sidebar class="col-sm-3" ></Sidebar>
        <section class="col-sm-9">
            <SearchForm v-bind:search="search"></SearchForm>
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
            </header>
            <router-view></router-view>
        </section>
    </div>
</template>
<script>
import Sidebar from '../components/SidebarComponent.vue';
import SearchForm from '../forms/SearchForm.vue';
import List from '../components/ListComponent.vue';
import store from '../store/index.js';

export default {
    name : 'admin',
    components:{
        Sidebar, SearchForm, List
    },
    data() {
        return {
            title: '',
            search: '',
            show: false,
            paginator:{}
        }
    },
    beforeCreate () {
        if (!store.state.isLogged) {
            this.$router.go('/usuario/login')
        }
    },
    watch:{
        search(novo,antigo){
            this.$router.push(`/admin/listar/${novo}`)
        }
    },
    methods:{

    }
}
</script>
<style lang="scss" scoped>
.page-header > h1 { margin-top: 0px; }
</style>

