<template>
    <div class="row">
        <form v-on:submit.prevent="createConteudo()">
            
            <div class="panel panel-default col-md-7">
                <div class="panel-heading">
                    Adicionar
                </div>
                <div class="panel-body">
                    <!-- TITULO -->
                    <div class="form-group">
                        <label for="titulo">Título:*</label>
                        <input type="text" class="form-control" id="titulo" v-model="title">                        
                    </div>                    
                    <!-- DESCRICAO -->
                    <div class="form-group">
                        <label for="idambientedeapoiocategoria">Descrição:*</label>
                        <textarea class="form-control" id="idambientedeapoiocategoria" v-model="description" style="resize: none"></textarea>
                    </div>
                    <!-- TIPO -->
                    <div class="form-group">
                        <label for="estado">Categotia:*</label>
                        <select name="idambientedeapoiocategoria" id="idambientedeapoiocategoria" class="form-control" v-model="tipo">
                            <option value="">« SELECIONE »</option>
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
                        <label for="tags">Palavra-Chave:*</label>
                        <textarea class="form-control" id="tags" v-model="description" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="icone">URL  do projeto:</label>
                        <input type="file" class="form-control" id="icone" name="icone" aria-describedby="icone">
                        <small id="login_usuario" class="form-text text-muted">Imagem no formato .png com tamanho de 250px (altura) e 250px (largura)</small>               
                    </div>
                    <div class="form-group">
                        <label for="usopedagogico">Informações para o uso pedagógico:</label>
                        <textarea class="form-control" id="usopedagogico" v-model="description" style="resize: none"></textarea>
                    </div>
                <div class="form-group">
                    <button class="btn btn-default">Enviar</button>
                </div>
            </div>
            
        </form>
    </div>
</template>

<script>
import Http from '../http.js';

export default {
    name: 'ConteudoForm',
    data(){
        return {
            tipo: null,
            title: null,
            description:null,
            authors:null,
            source:null,
            license:null
        }

    },
    methods:{
        async createConteudo(){
            let data = {
                tipo: this.tipo,
                title: this.title,
                description:this.description,
                authors:this.authors,
                source:this.source,
                license:this.license
            };
            console.warn(data);
            //let http = new Http();
            //let resp = await http.postData('/conteudos/', data);

        }
    }

}
</script>
