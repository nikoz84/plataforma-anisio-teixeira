<template>
    <div class="conteiner">
        <div class="row col-lg-6 col-xs-offset-3">
            <h2><legend>ListaUsuários</legend></h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>E-mail institucional</td>
                        <td>Tipo de usuário</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td><button type="button" class="btn btn-warning btn-xs">Editar</button> <button type="button" class="btn btn-danger btn-xs">Excluir</button></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
import Http from '../http.js';
const http = new Http();

export default {
    name: 'ListarUser',

    props: ['users'],

    data(){
        
    },

    methods:{
        getUsuarios: function() {
            var urlUsuarios = 'usuario.listar';
            axios.get(urlUsuarios).then(response => {
                this.usuarios = response.data
            });
        }
        },

    }

</script>