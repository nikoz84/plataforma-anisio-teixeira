<template>
    <nav class="list-group">
        <a href="#" class="thumbnail">
            <img class="w-150" v-bind:src="'https://via.placeholder.com/300x200'" alt="Foto Usuário">
        </a>
        <p>{{ 'Benvindo ' + username }}</p>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'inicio', action:'estatisticas' }}">
            <a>Inicio</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'aplicativos', action:'listar' }}">
            <a>Aplicativos</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'conteudos', action:'listar' }}">
            <a>Conteúdos</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'canais', action:'listar' }}">
            <a>Canais</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'licenses', action:'listar' }}">
            <a>Licenças</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'tags', action:'listar' }}">
            <a>Palavras chave</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'usuarios', action:'listar' }}">
            <a>Usuários</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'denuncias', action:'listar' }}">
            <a>Denúncias</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'usuarios', action:'alterar-senha' }}">
            <a>Alterar senha</a>
        </router-link>
        <router-link tag="li" :to=" {name:'admin', params: { slug: 'usuarios', action:'adicionar' }}">
            <a>Adicionar Usuário</a>
        </router-link>
        
        
    </nav>
</template>
<script>
import client from "../client.js";

export default {
  name: "Sidebar",
  data() {
    return {
      username: localStorage.getItem("username"),
      userId: localStorage.getItem("idUser"),
    };
  },
  mounted() {},
  methods: {
    async get(endpoint) {
      this.$parent.show = false;

      let params = { token: localStorage.token };
      let resp = await client.get(`/${endpoint}`, params);

      if (resp.data.success) {
        this.$parent.paginator = resp.data.paginator;
        this.$parent.title = resp.data.title;
        this.$parent.search = endpoint;
        this.$parent.show = true;
      }
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

