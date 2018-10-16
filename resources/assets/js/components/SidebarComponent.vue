<template>
    <nav class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" src="https://robohash.org/32" alt="Foto Usuário">
        </a>
        <p>{{ 'Benvindo ' + username }}</p>
        <a v-on:click="getCanais" class="list-group-item pointer">Canais</a>
        <a v-on:click="getUsers" class="list-group-item pointer">Usuários</a>
        <a v-on:click="getConteudos" class="list-group-item pointer">Mídias Educacionais</a>
        <a v-on:click="getAplicativos" class="list-group-item pointer">Aplicativos Educacionais</a>
        <a v-on:click="getTags" class="list-group-item pointer">Tags</a>
        <a v-on:click="getLicencas" class="list-group-item pointer">Licenças</a>
    </nav>
</template>
<script>

export default {
    name : 'Sidebar',
    data() {
        return {
            username: localStorage.getItem('username'),
            user_id: localStorage.getItem('user_id'),    
        }
    },
    methods:{
        getCanais( ){
            axios.get('/api-v1/canais').then(resp =>{
                console.log(resp);
            }).catch( error => {

            });
            
            // this.$parent.items =
        },
        getUsers() {
            
            axios.get('/api-v1/users',{ token:localStorage.getItem('token') } )
                .then(resp =>{
                    console.log(resp);
                })
                .catch( error => {

                });
                
        },
        getConteudos() {
            axios.get('/api-v1/conteudos')
                .then(resp =>{
                    console.log(resp);
                })
                .catch( error => {

                });
        },
        getAplicativos() {
            axios.get('/api-v1/aplicativos')
                .then(resp =>{
                    console.log(resp);
                })
                .catch( error => {

                });
        },
        getTags() {
            axios.get('/api-v1/tags')
                .then(resp =>{
                    console.log(resp);
                })
                .catch( error => {

                });
        },
        getLicencas() {
            console.log('licenças')    
        },

    }
}
</script>
<style lang="sass" scoped>
.pointer { cursor: pointer; }
.w-150 { width: 150px; }
</style>

