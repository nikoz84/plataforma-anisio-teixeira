<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos da Diretória</title>
</head>

<body>

    {{--  @foreach ($diretorio as $folder)
        <strong>
            Nome da pasta: {{ basename($folder) }}<br />
        </strong>
        @foreach ($arquivos as $file)
            <p>
                <input type="text" value="{{ $file }}" id="caminho-{{ $loop->index }}">
                <button onclick="copiarCaminho({{ $loop->index }})">Copiar link</button>
            </p>
        @endforeach
    @endforeach  --}}
    @foreach ($root as $key => $file)
        Nome da pasta: {{ basename($key) }}<br />
    @endforeach
    @foreach ($subdiretorios as $diretorio)
        {{ $diretorio }}
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
