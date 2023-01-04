<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos da Diretória</title>
</head>

<body>
    <ul>
        @foreach ($root as $key => $value )
        <li>
            <strong>
            Nome da pasta: {{ $key->name }}<br />
    </strong>
       
            @foreach ($tree as $value)
                  <p>
            <input type="text" value="{{ $value }}" id="caminho-{{ $loop->index }}">
            <button onclick="copiarCaminho({{ $loop->index }})">Copiar link</button>
        </p>
            @endforeach
      

               
            </li>
            @endforeach
        </ul>
    


</body>

</html>
<script>
    function copiarCaminho(indice) {
        var input = document.getElementById('caminho-' + indice);
        input.select();
        document.execCommand('copy');
    }
</script>
