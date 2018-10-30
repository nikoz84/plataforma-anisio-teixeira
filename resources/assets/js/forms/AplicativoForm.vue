<template>
    <div class="row">
        <form v-on:submit.prevent="createAplicativo()">
            
            <div class="panel panel-default col-md-7">
                <div class="panel-heading">
                    Adicionar Aplicativos
                </div>
                <div class="panel-body">
                    <!-- TITULO -->
                    <div class="form-group">
                        <label for="titulo">Nome do aplicativo:*</label>
                        <input type="text" class="form-control" id="titulo" v-model="name">
                    </div>
                    <!-- URL -->
                    <div class="form-group">
                        <label for="url">URL:*</label>
                        <input type="text" class="form-control" id="url" v-model="url">
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group">
                        <label for="descricao">Descrição:*</label>
                        <textarea class="form-control" id="descricao" v-model="description" style="resize: none"></textarea>
                    </div>
                    <!-- TIPO -->
                    <div class="form-group">
                        <label for="estado">Categoria:*</label>
                        <select name="idambientedeapoiocategoria" id="idambientedeapoiocategoria" class="form-control" v-model="categoria">
                            <option value="0">« SELECIONE »</option>
                            <option value="8">Ambiente de Aprendizagem</option>
                            <option value="9">Ambiente de Programação</option>
                            <option value="10">Aplicativos Educacionais</option>
                            <option value="11">Aplicativos para Escritório</option>
                            <option value="36">Biblioteca</option>
                            <option value="12">Editor de Animação</option>
                            <option value="13">Editor de Imagem</option>
                            <option value="20">Editor de Vídeo</option>
                            <option value="37">Editor de Áudio</option>
                            <option value="22">Gerenciador de Conteúdo</option>
                            <option value="14">Gerenciador de Projetos</option>
                            <option value="18">Gerenciador de Revistas</option>
                            <option value="38">Internet</option>
                            <option value="23">Portais Educacionais</option>
                            <option value="21">Sistemas Operacionais Livres</option>
                        </select>
                    </div>
                    <!-- DESCRICAO -->
                    <div class="form-group">
                        <label for="tags">Palavra-Chave:* </label>
                        <textarea class="form-control" id="tags" v-model="tags" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="icone">URL  do projeto:</label>
                        <input type="file" class="form-control" id="icone" name="icone" aria-describedby="icone">
                        <small id="login_usuario" class="form-text text-muted">Imagem no formato .png com tamanho de 250px (altura) e 250px (largura)</small>               
                    </div>
                    <div class="form-group">
                        <label for="usopedagogico">Informações para o uso pedagógico:</label>
                        <textarea class="form-control" id="usopedagogico" v-model="uso_pedagogico" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="destaque">Marcar como destaque</label>
                        <input type="checkbox" id="destaque" v-model="is_featured">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Http from '../http.js';

export default {
    name: 'AplicativoForm',
    data(){
        return {
            name: null,
            description:null,
            categoria: 0,
            url: null,
            is_featured: false,
            uso_pedagogico: null,
            tags:[],
            option: {},
        }

    },
    methods:{
        async createAplicativo(){
            
            let data = {
                name: this.name,
                description:this.description,
                category: this.categoria,
                url: this.url,
                is_featured: this.is_featured,
                options: JSON.stringify(this.options),
                token: localStorage.token
            };
            console.warn(data)
            let http = new Http();
            //let resp = await http.postData('/aplicativos/create', data);

            //if(resp.data.success){
              //  console.warn(resp.data.message)
            //}



        }
    }

}
</script>
