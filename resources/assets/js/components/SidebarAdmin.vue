<template>
    <aside class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" v-bind:src="'https://via.placeholder.com/300x200'" alt="Foto Usuário">
        </a>
        <p>{{ 'Benvindo ' + username }}</p>
        <nav class="list-group">
            <router-link :to=" { name:'admin', params: { slug: 'analytics', action: 'listar' }}">
                <a class="list-group-item">Inicio</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'aplicativos', action:'listar' }}" >
                <a class="list-group-item">Aplicativos</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'conteudos', action:'listar' }}" >
                <a class="list-group-item">Conteúdos</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'canais', action:'listar' }}" >
                <a class="list-group-item">Canais</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'licenses', action:'listar' }}" >
                <a class="list-group-item">Licenças</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'tags', action:'listar' }}" >
                <a class="list-group-item">Palavras chave</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'usuarios', action:'listar' }}" >
                <a class="list-group-item">Usuários</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'roles', action:'listar' }}" >
                <a class="list-group-item">Roles</a>
            </router-link>
            <router-link :to=" { name:'admin', params: { slug: 'denuncias', action:'listar' }}" >
                <a class="list-group-item">Denúncias</a>
            </router-link>
        </nav>
        


    </aside>
</template>
<script>
export default {
  name: "SidebarAdmin",
  data() {
    return {
      username: localStorage.getItem("username"),
      userId: localStorage.getItem("idUser")
    };
  },
  mounted() {},
  methods: {}
};
</script>
<style lang="sass" scoped>

</style>

