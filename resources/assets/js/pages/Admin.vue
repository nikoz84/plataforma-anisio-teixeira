<template>
    <div>
        <h1>{{ title }}</h1>
        <Sidebar class="col-sm-3"></Sidebar>
        <Content class="col-sm-9"></Content>
    </div>
</template>
<script>
import Sidebar from '../components/SidebarComponent.vue';
import Content from '../components/ContentComponent.vue';

export default {
    name : 'admin',
    components:{
        Sidebar, Content
    },
    data() {
        return {
            title: 'Admin'
        }
    },
    methods:{
        getConteudos(){
        axios.get('/users')
        .then(function (response) {
            // handle success
            console.log(response);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
        }
    }
}
</script>
<style lang="sass" scoped>

</style>

