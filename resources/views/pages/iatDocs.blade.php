<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <title>Documentos da Diretória</title>
</head>

<body>

    <section class="container">

        <br />

        @php
            function showItem($item)
            {
                if (array_key_exists('file', $item)) {
                    echo '<li id="collapseOne" class="arquivo d-flex p-2">' . $item['file'] . '';
                    echo '<input hidden type="text" value="' . $item['path'] . '" id="text_' . $item['file'] . '">';
                    echo '<i class="muted">
                <button type="button" class="btn-clipboard mt-0 me-0" aria-label="Copiar Link" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<b>Copiar link</b>
                <br>para área de transferência" data-bs-original-title="Copiar Link" id="button_' .
                        $item['file'] .
                        '" data-link_arquivo="' .
                        $item['url'] .
                        '" onClick="copiar(this)">
                    <i class="bi bi-clipboard" width="48" height="48">
                    </i>
                </button>
            </i>
        </li>';
                } elseif (array_key_exists('children', $item)) {
                    $nmpasta = strtr($item['label'], ' ', '_');
                    echo '<ul class="accordion mt-3 mb-3" style="list-style: none">
            <div class="accordion-item">
                <h2 class="diretorio accordion-header fa-folder fas">
                    <button class="accordion-button text-uppercase 
                    collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' .
                        $nmpasta .
                        '" 
                    aria-expanded="false" aria-controls="collapseOne">
                        ' .
                        $item['label'] .
                        '
                    </button>
                </h2>
                <div id="collapse' .
                        $nmpasta .
                        '" class="collapse">';
                    foreach ($item['children'] as $actual) {
                        showItem($actual);
                    }
                    echo '
                </div>
            </div>
        </ul>';
                }
        } @endphp
        <h3 class="text-bg-primary p-3">Estrutura de Arquivos</h3>
        <a href="{{ route('form.upload') }}" type="button" class="btn btn-primary" {{--  data-bs-toggle="modal"  --}}
            {{--  data-bs-target="#uploadModal"  --}}>
            upload
        </a>
        <ul class="p-0 ul-mae">
            @php
                showItem($tree);
            @endphp

        </ul>

    </section>

</body>
<script type="text/javascript" defer>
    async function copiar(item) {
        if (navigator.clipboard) {
            try {
                await navigator.clipboard.writeText(item.dataset.link_arquivo);
            } catch (e) {
                fallbackCopyText(item.dataset.link_arquivo);
            }
        } else {
            fallbackCopyText(item.dataset.link_arquivo);
        }
    }

    function fallbackCopyText(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        textArea.remove();
        console.log("Texto copiado com sucesso usando o fallback document.execCommand('copy')");
    }
</script>

<script type="text/javascript" defer>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

</html>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .ul-mae>ul {
        padding-left: 0;
    }

    .accordion-button::before {
        display: inline-block;
        content: "\F3D7";
        font-family: bootstrap-icons !important;
        font-style: normal;
        font-weight: normal !important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        vertical-align: -0.125em;
        -webkit-font-smoothing: antialiased;
        margin-right: 10px;
        font-size: 24px;
        margin-top: -4px px;
    }

    .accordion-button:not(.collapsed)::before {
        display: inline-block;
        content: "\f3d8";
        font-family: bootstrap-icons !important;
        font-style: normal;
        font-weight: normal !important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        vertical-align: -0.125em;
        -webkit-font-smoothing: antialiased;
        margin-right: 10px;
        font-size: 24px;
        margin-top: -4px px;
    }

    .btn-clipboard {

        color: #212529;
        background-color: transparent;
        border: 0;
        font-size: 20px;
        line-height: 1px;
        padding-left: 1rem;
    }

    .arquivo {
        border-bottom: 1px solid #dee2e6;
    }

    .arquivo:nth-child(even) {
        background-color: #f7f7ff;
    }

    .accordion {
        --bs-accordion-btn-focus-border-color: transparent;
        --bs-accordion-btn-focus-box-shadow: none;
    }
</style>
