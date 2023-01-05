<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Documentos da Diretória</title>
</head>

<body>
    <h5>Listar todos os arquivos da para raiz {{ $diretorio->folder_name }}</h5>
    <ul>
        @foreach ($diretorio->files as $file)
            <li><a href="{{ $file->get('url') }}" download> {{ $file->get('name') }} </a> - {{ $file->get('size') }}
            </li>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
</body>

</html>
