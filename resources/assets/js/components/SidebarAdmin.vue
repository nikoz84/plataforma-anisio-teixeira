<template>
    <nav class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" v-bind:src="'https://via.placeholder.com/300x200'" alt="Foto Usuário">
        </a>
        <p>{{ 'Benvindo ' + username }}</p>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'inicio', action:'estatisticas' }}" class="menu_admin">
            <a>Inicio</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'aplicativos', action:'listar' }}" class="menu_admin">
            <a>Aplicativos</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'conteudos', action:'listar' }}" class="menu_admin">
            <a>Conteúdos</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'canais', action:'listar' }}" class="menu_admin">
            <a>Canais</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'licenses', action:'listar' }}" class="menu_admin">
            <a>Licenças</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'tags', action:'listar' }}" class="menu_admin">
            <a>Palavras chave</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'usuarios', action:'listar' }}" class="menu_admin">
            <a>Usuários</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'denuncias', action:'listar' }}" class="menu_admin">
            <a>Denúncias</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'usuarios', action:'alterar-senha' }}" class="menu_admin">
            <a>Alterar senha</a>
        </router-link>
        <router-link tag="li" :to=" { name:'admin', params: { slug: 'usuarios', action:'adicionar' }}" class="menu_admin">
            <a>Adicionar Usuário</a>
        </router-link>


    </nav>
</template>
<script>

export default {
  name: "SidebarAdmin",
  data() {
    return {
      username: localStorage.getItem("username"),
      userId: localStorage.getItem("idUser"),
    };
  },
  mounted() {},
  methods: {
    async get(endpoint) {
      let resp = await axios.get(`/${endpoint}`);

      if (resp.data.success) {
        //this.$parent.paginator = resp.data.paginator;
        
      }
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

