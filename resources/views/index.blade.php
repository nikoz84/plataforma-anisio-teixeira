<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title)</title>

    <meta name="description" content="@yield('description', $description)">
    <meta name="keywords" content="@yield('keywords', $keywords)">

    <meta name="title" content="@yield('title', $title)">
    <meta name="author" content="@yield('author', $author)">
    <meta name="url" content="@yield('url', $url)">

    <meta property="og:title" content="@yield('title', $title)" />
    <meta property="og:description" content="@yield('description', $description)" />
    {{-- <meta property=”og:type” content=”{{ $meta->og_type }}”/> --}}
    <meta property="og:image" content="'image',$image ? $image :" />
    <meta property="og:locale" content="@yield('locale', $locale)" />
    <meta property="og:sitename" content="@yield('sitename', $sitename)" />
    <meta property="og:url" content="@yield('url', $url)" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('description', $description)">
    <meta name="twitter:site" content="@yield('url', $url)" />
    <meta name="twitter:title" content="@yield('title', $title)">
    <meta name="twitter:creator" content="@yield('author', $author)" />
    <meta name="twitter:image" content="'image' , $image ? $image :">

    <link rel="canonical" href="@yield('canonical', $canonical)">
    <link rel="manifest" href="/build/manifest.json" preload>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta name="msapplication-TileColor" content="#08275e">
    <meta name="theme-color" content="#08275e">
    <!--  rel="preload" as="style" onload="this.rel='stylesheet'" async -->
    {{-- <link rel="stylesheet" href="{{ asset('/css/app.css') }}" async media="print" onload="this.media='all'"> --}}
    <!--link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"-->
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" crossorigin="anonymous" async-->
    @vite(['resources/js/app.js'])
</head>

<body>
    <noscript>
        A Plataforma Anísio Teixeira utiliza Javascript para ser executada,
        por favor, habilite o javascript no navegador.
    </noscript>

    <div id="app"></div>


    <div id="vlibras" vw class="enabled" style="top:45% !important;">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    {{-- @vite(['resources/js/app.js']) --}}


    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
    {{-- @if (config('app.env') === 'local')
        <script async defer src="{{ asset('/js/app.js') }}"></script>
    @elseif (config('app.env') === 'production')
        <script async defer src="{{ asset('/js/manifest.js') }}"></script>
        <script async defer src="{{ asset('/js/vendor.js') }}"></script>
        <script async defer src="{{ asset('/js/app.js') }}"></script>
    @endif --}}
</body>

</html>
