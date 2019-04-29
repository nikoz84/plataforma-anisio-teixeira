<template>
    <div>
        <h4 class="text-center">Posts</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Título</th>
                <th scope="col">Descrição</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(conteudo,i) in conteudos" :key="i">
                <td>{{conteudo.title}}</td>
                <td>{{conteudo.description}}</td>
                <td>
                    <button class="btn btn-danger" @click="deletePost(conteudo.id)"><i style="color:white" class="fa fa-trash"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import {mapActions, mapGetters} from 'vuex';

export default {
    name: 'ListConteudosAdmin',
    mounted() {
        this.$store.dispatch('fetchConteudos')
    },
    methods: {
        deleteConteudo(id) {
            this.$store.dispatch('deleteConteudo', id)
        }
    },
    computed: {
        ...mapGetters([
            'conteudos'
        ])
    }

}
</script>

