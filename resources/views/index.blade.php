<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{env('APP_NAME')}}</title>
        <meta name="description" content="{{env('APP_NAME')}} projeto da Secretaria da Educação do Estado da Bahia (SEC)">
        <meta name="keywords" content="plataforma anísio teixeira, recursos educacionais, educação, conteúdos digitais, software livre, emitec, tv anísio teixeira">
        <link rel="canonical" href="{{env('APP_URL')}}">
        <link rel="manifest" href="/manifest.json" preload>
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        <meta name="msapplication-TileColor" content="#08275e">
        <meta name="theme-color" content="#08275e">
        <!--  rel="preload" as="style" onload="this.rel='stylesheet'" async -->
        <link rel="stylesheet" href="/css/app.css" async >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" crossorigin="anonymous" async>
        <noscript>
            <link rel="stylesheet" href="/css/app.css"/>
        </noscript>
    </head>
    <body>
        <noscript>
            A Plataforma Anísio Teixeira utiliza Javascript para ser executada, 
            por favor, habilite o javascript no navegador.
        </noscript>
        
        <div id="app">
            <main-app></main-app>
        </div>
        
        @if (env('APP_ENV') === 'development')
        <script async defer src="/js/app.js"></script>
        @elseif (env('APP_ENV') === 'production')
        <script async defer src="/js/manifest.js"></script>
        <script async defer src="/js/js/vendor.js"></script>
        <script async defer src="/js/js/app.js"></script>
        @endif
    </body>
</html>
