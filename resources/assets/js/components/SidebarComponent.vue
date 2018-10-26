<template>
    <nav class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" v-bind:src="'https://via.placeholder.com/300x200'" alt="Foto Usuário">
        </a>
        <p>{{ 'Benvindo ' + username }}</p>
        <a v-on:click="get('canais')" class="list-group-item pointer">Canais</a>
        <a v-on:click="get('users')" class="list-group-item pointer">Usuários</a>
        <a v-on:click="get('conteudos')" class="list-group-item pointer">Mídias Educacionais</a>
        <a v-on:click="get('aplicativos')" class="list-group-item pointer">Aplicativos Educacionais</a>
        <a v-on:click="get('tags')" class="list-group-item pointer">Tags</a>
        <a v-on:click="get('licencas')" class="list-group-item pointer">Licenças</a>
    </nav>
</template>
<script>
import Http from '../http.js';

export default {
    name : 'Sidebar',
    data() {
        return {
            username: localStorage.getItem('username'),
            userId: localStorage.getItem('idUser'),
        }
    },
    methods:{
        async get(endpoint){
            this.$parent.show = false;
            let http = new Http();
            let resp = await http.getDataFromUrl(endpoint);
            console.log(resp.data)
            this.$parent.paginator = resp.data.paginator;
            this.$parent.title = resp.data.title;
            this.$parent.search = endpoint;
            this.$parent.show = true;
            
        }

    }
}
</script>
<style lang="sass" scoped>
.w-150 { width: 150px; }
</style>

