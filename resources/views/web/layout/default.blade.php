<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title', $title)</title>

        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        
        
    </head>
    <body>
        <noscript>
            A Plataforma Anísio Teixeira utiliza Javascript para ser executada, 
            por favor, habilite o javascript no navegador.
        </noscript>
        
        @include('web.components.navbar')

        
        @yield('content')
        
    </body>
</html>
