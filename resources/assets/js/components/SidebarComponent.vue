<template>
    <nav class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" src="https://robohash.org/32" alt="Foto Usuário">
        </a>
        <p>Nome do usuário</p>
        <a v-on:click="getCanais" class="list-group-item pointer">Canais</a>
        <a v-on:click="getUsers" class="list-group-item pointer">Usuários</a>
        <a v-on:click="getConteudos" class="list-group-item pointer">Mídias Educacionais</a>
        <a v-on:click="getAplicativos" class="list-group-item pointer">Aplicativos Educacionais</a>
        <a v-on:click="getTags" class="list-group-item pointer">Tags</a>
        <a v-on:click="getLicencas" class="list-group-item pointer">Licenças</a>
    </nav>
</template>
<script>
import Http from '../http-service.js';

export default {
    name : 'Sidebar',
    data() {
        return {
            
        }
    },
    methods:{
        getCanais: function(){
            let result = new Http('canais').getData();
            
            result.then(res => {
                this.$parent.data = res.data;
            })
            
            // this.$parent.items =
        },
        getUsers: async function(){
            
                
        },
        getConteudos: function(){
            console.log('conteudos')
        },
        getAplicativos: function(){
            console.log('aplicativos')
        },
        getTags: function(){
            console.log('tags')
        },
        getLicencas: function(){
            console.log('licenças')    
        },

    }
}
</script>
<style lang="sass" scoped>
.pointer { cursor: pointer; }
.w-150 { width: 150px; }
</style>

