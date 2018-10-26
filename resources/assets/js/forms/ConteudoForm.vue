<template>
    <div class="conteiner">

        <form v-on:submit.prevent="createConteudo()">

            <div class="row">
                
            <div class="panel panel-default col-md-7">
            <div class="panel-heading">Adicionar conteúdo digital</div>
            <div class="panel-body">
            
            <div class="form-group">
                <label for="titulo">Título:*</label>
                <input type="text" class="form-control" id="titulo" aria-describedby="titulo">
                <small id="titulo" class="form-text text-muted">Adicione o nome original da mídia.</small>
            </div>

            <div class="form-group">
            <label for="estado">Tipo de Conteúdo:*</label>
            <select class="form-control form-control-lg" id="licenca-relacionada">
                <option value="">« SELECIONE »</option>
                <option value="7">Animação/Simulação</option>
                <option value="3">Apresentação</option>
                <option value="4">Áudio</option>
                <option value="1">Documento/Experimento</option>
                <option value="6">Imagem</option>
                <option value="2">Planilha</option>
                <option value="10">Sequência Didática</option>
                <option value="8">Site</option>
                <option value="9">Software Educacional</option>
                <option value="5">Vídeo</option>
            </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:*</label>
                <textarea class="form-control" id="descricao"></textarea>
            </div>

            <div class="form-group">
                <label for="palavra-chave">Palavras-Chave:*</label>
                <input type="text" class="form-control" id="palavra-chave">
            </div>

            <div class="form-group">
                <label for="autores">Autores:*</label>
                <input type="text" class="form-control" id="autores">
            </div>

            <div class="form-group">
                <label for="fonte">Fonte:*</label>
                <input type="text" class="form-control" id="fonte">
            </div>

            <div class="form-group">
            <label for="licenca-conteudo">Licença de Conteúdo:*</label>
            <select class="form-control form-control-lg" id="licenca-conteudo">
                <option value="">« SELECIONE »</option>
                <option value="1">Outros</option>
                <optgroup id="idconteudolicenca-optgroup-Creative Commons" label="Creative Commons">
                    <option value="6">Atribuição CC BY</option>
                    <option value="7">Atribuição-CompartilhaIgual CC BY-SA</option>
                    <option value="8">Atribuição-SemDerivações CC BY-ND</option>
                    <option value="9">Atribuição-NãoComercial CC BY-NC</option>
                    <option value="10">Atribuição-NãoComercial-CompartilhaIgual CC BY-NC-SA</option>
                    <option value="11">Atribuição-NãoComercial-SemDerivados CC BY-NC-ND</option>
                    <option value="12">Atribuição CC 0</option>
                </optgroup>
                <option value="3">Todos direitos reservados (Copyright)</option>
                <option value="4">Domínio público</option>
                <option value="5">GPL</option>
                <option value="13">MIT</option>
            </select>
            </div>

            <div class="form-group">
                <label for="icone-licenca">Icone da Licença:*</label>
                <input type="file" class="form-control" id="icone-licenca" aria-describedby="icone-licenca">
                <small id="icone-licenca" class="form-text text-muted">Imagem no formato .png, dimensão: 200px x 90px, tamanho máximo: 600KB</small>
            </div>

            </div>
            </div>

            <div class="panel panel-default col-md-5">
            <div class="panel-heading">Selecione o(s) componente(s) curricular(es) ou disciplina(s) que mais se adequem ao contéudo:</div>
            <div class="panel-body">
            

            </div>
            </div>


            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
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
            
        }

    },
    methods:{
        async createConteudo(){
            let http = new Http({name:'felipe',email:'felipe@gmail.com',password:'123456'});
            let resp = await http.postData();
            console.warn(resp);
        }
    }

}
</script>
