<template>
    <div class="conteiner">

        <form>

            <div class="form-group">
                <label for="titulo">Titulo:*</label>
                <input type="text" class="form-control" id="titulo">
            </div>

            <div class="form-group">
                <label for="desc-categoria">Descrição categoria:*</label>
                <textarea id="desc-categoria" name="desc-categoria" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="canal">Canal:</label>
                <select class="form-control form-control-lg" id="canal" aria-describedby="canal">
                    <option value="">« SELECIONE UM CANAL »</option>
                </select>
                <small id="canal" class="form-text text-muted">Selecione uma categoria se precisar agrupar por sub-categorias</small>               
            </div>

            <div class="form-group">
                <label for="categoria-relacionada">Categoria relacionada:*</label>
                <input type="text" class="form-control" id="categoria-relacionada">                
            </div>

            <div class="form-group">
                <label for="assunto">URL:</label>
                <input type="text" class="form-control" id="url" value="http://pat.educacao.ba.gov.br/">
            </div>

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>