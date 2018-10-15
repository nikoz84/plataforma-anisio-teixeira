<template>
    <div>

        <Sidebar class="col-sm-3"></Sidebar>
        <section class="col-sm-9">
            
            <Search class="row"></Search>

            <List class="row mt-15" items></List>
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
            data: {}
        }
    },
    methods:{
        
    }
}
</script>
<style lang="sass" scoped>
.mt-15{ margin-top: 15px; }
</style>

