<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Plataforma Anísio Teixeira</title>

        <!-- Fonts -->

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <main class="container-fluid">
            <header class="page-header">
                <h1 class="text-center" style="font-size:1.5rem;"> Documentação API Plataforma Anísio Teixeira</h1>
            </header>
            <section class="row">
                <aside class="col-sm-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="#">Conteúdos</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#">Aplicativos</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#">Usuarios</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#">Opções</a>
                        </li>
                    </ul>
                </aside>
                <article class="col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Conteudos</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rota: {{ url('/') }}/api-v1/conteudos </h6>
                            <div class="card-text">Descrição</div>
                        </div>
                    </div>
                </article>
            </section>
        </main>
        

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
