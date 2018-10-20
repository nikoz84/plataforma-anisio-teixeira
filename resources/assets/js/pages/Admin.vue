<template>
    <div>
        <Sidebar class="col-sm-3"></Sidebar>
        <section class="col-sm-9">
            <header class="page-header">
                <h1>{{ title }}<small class="pull-rigth"> {{ complementTitle }}</small></h1>

                <Search></Search>
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
        </section>
    </div>
</template>
<script>
import Sidebar from '../components/SidebarComponent.vue';
import Search from '../components/SearchComponent.vue';
import List from '../components/ListComponent.vue';

export default {
    name : 'admin',
    components:{
        Sidebar, Search, List
    },
    data() {
        return {
            title: 'Administração',
            paginator: {},
            complementTitle: ''
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

