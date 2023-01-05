<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos da Diretória</title>
</head>

<body>
    <h5>Listar todos os arquivos da para raiz {{ $diretorio->folder_name }}</h5>
    <ul>
        @foreach ($diretorio->files as $file)
            <li><a href="{{ $file->get('url') }}" download> {{ $file->get('name') }} </a> - {{ $file->get('size') }}</li>
        @endforeach
    </ul>

    <h5>Lista de subdiretorios</h5>
    <ul>
        @foreach ($subdiretorios as $subdiretorio)
            <li>
                {{ $subdiretorio->folder_name }}
                <ul>
                    @foreach ($subdiretorio->files as $file)
                        <li>
                            <a href="{{ $file->get('url') }}" download> {{ $file->get('name') }} </a> -
                            {{ $file->get('size') }}
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        </li>

</body>

</html>
<script>
    function copiarCaminho(indice) {
        var input = document.getElementById('caminho-' + indice);
        input.select();
        document.execCommand('copy');
    }
</script>
