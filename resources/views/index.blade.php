<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Plataforma Anísio Teixeira</title>
        <meta name="description" content="Plataforma Anísio Teixeira projeto da Secretaria da Educação do Estado da Bahia(SEC)">
        <meta name="keywords" content="educação, emitec, plataforma anísio teixeira, conteúdos digitais, secretaria da educação, software livre">
        <link rel="manifest" href="/manifest.json">
        <link rel="apple-touch-icon" href="/img/icons-192.png">
        <meta name="theme-color" content="#08275e">
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

        <!--script src="https://www.google.com/recaptcha/api.js" async defer></!--script -->
    </head>
    <body>
        <div id="app">
            <main-app></main-app>
        </div>
        
        <script src="{{ asset('js/app.js') }}"></script>
        <noscript>
            A Plataforma Anísio Teixeira utiliza Javascript para ser executada, 
            por favor, habilite o javascript no navegador.
        </noscript>
    </body>
</html>
