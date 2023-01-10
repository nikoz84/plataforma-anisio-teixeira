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

    <section class="container">
        <br />

        @php
            function showItem($item)
            {
                if (array_key_exists('file', $item)) {
                    echo '<li><i class="fas fa-file">' . $item['file'] . '</i></li>';
                    echo '<input type="text" value="' . $item['path'] . '" id="text_' . $item['file'] . '">';
                    echo '<button id="button_' . $item['file'] . '" data-link_arquivo="' . $item['path'] . '" onClick="copiar(this)">Copiar link</button>';
                } elseif (array_key_exists('children', $item)) {
                    echo '<ul><i class="fas fa-folder">' . $item['label'] . '</i>';
                    foreach ($item['children'] as $actual) {
                        showItem($actual);
                    }
                    echo '</ul>';
                }
            }
        @endphp

        <h5>Lista de subdiretorios</h5>
        <ul>
            @php
                showItem($tree);
            @endphp
            {{--           @foreach ($subdiretorios as $subdiretorio)
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
            @endforeach --}}

        </ul>
        {{-- <h5 class="mt-5">Listar todos os arquivos da pasta raiz <b
               class="text-primary">{{ $diretorio->folder_name }}</b></h5>  --}}
        {{-- <ul> 
            @foreach ($diretorio->files as $file)
                <li>
                    <a href="{{ $file->get('url') }}" download> {{ $file->get('name') }} </a> -
                    {{ $file->get('size') }}
                </li>
            @endforeach
        </ul>  --}}
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>
<script type="text/javascript" defer>
    function copiar(item) {
        navigator.clipboard.writeText(item.dataset.link_arquivo);
    }
    //const textInput = document.getElementById('text');
    //const copyButton = document.getElementById('copy');

    /*copyButton.addEventListener('click', () => {
        textInput.select();
        document.execCommand('copy');
    });*/
    /*function copiarCaminho(indice) {
        var input = document.getElementById('caminho-' + indice);
        input.select();
        document.execCommand('copy');
    }*/
</script>

</html>
