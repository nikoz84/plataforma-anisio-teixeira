<template>
    <div class="conteiner">
        <form>
            <!-- NOME -->
            <div class="form-group">
                <label for="nomelicenca">Palavra chave:*</label>
                <input type="text" class="form-control" id="nomelicenca">
            </div>
            

            <div class="form-group">
                <button class="btn btn-default">Enviar</button>
            </div>

        </form>

    </div>
</template>
<script>
export default {
  name: "TagForm"
};
</script>