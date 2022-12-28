<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
</head>

<body>

    @foreach ($diretorios as $diretorio)
        <p>{{ class_basename($diretorio) }}</p>
        @foreach ($documentos as $documento)
            <p>{{ basename($documento) }}</p>
            <input type="text" value="{{ $documento }}" id="caminho-{{ $loop->index }}">
            <button onclick="copiarCaminho({{ $loop->index }})">Copiar link</button>
        @endforeach
    @endforeach
</body>

</html>
<script>
    function copiarCaminho(indice) {
        var input = document.getElementById('caminho-' + indice);
        input.select();
        document.execCommand('copy');
    }
</script>
