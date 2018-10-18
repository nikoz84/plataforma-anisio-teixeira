<template>
    <div>
        <!-- Sidebar -->
        <Sidebar class="col-sm-3" v-bind:search="search"></Sidebar>
        <section class="col-sm-9">
            <Search></Search>
            <header class="page-header">
                <h1><small>{{ title }}</small></h1>
            </header>
            <div>
                <ul class="list-unstyled" v-if="paginator.data" v-for="(item, i) in paginator.data" :key="i">
                    <li class="panel panel-default" v-bind:id="item.id">
                        <div class="panel-body">

                            <h4>{{ (item.name) ? item.name : item.title }}</h4>
                            <div class="pull-right">
                                <a>editar</a>
                                <a>deletar</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
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
.mt-15{ margin-top: 15px; }
.page-header { margin-top: 0px; }
.page-header > h1 { margin-top: 0px; }

</style>

