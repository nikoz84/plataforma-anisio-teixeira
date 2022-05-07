<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>PDF de usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>

<body>
<div class="container">
        <!-- Conteúdos por Tipo de Mídia -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Conteúdos por Tipo de Mídia</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_tipo as $type)
                        <tr>
                            <td>{{$type->name}}</td>
                            <td>{{$type->total}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- Conteúdos por Mês -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Conteúdos por Mês</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Mês</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_mes as $mes)
                        <tr>
                            <td>{{$mes->month}}</td>
                            <td>{{$mes->total}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- Conteúdos por Canal -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Conteúdos por Canal</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Canal</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_canal as $canal)
                        <tr>
                            <td>{{$canal->name}}</td>
                            <td>{{$canal->total}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- PAGINAS MAIS VISITADAS -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Páginas mais visitadas Google Analytics - últimos 6 meses</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Página</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_pages as $canal)
                        <tr>
                            <td>{{$canal['url']}}</td>
                            <td>{{$canal['pageViews']}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- REPORT POR BROWSER -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Navegadores mais Utilizados Google Analytics - últimos 6 meses</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Browser</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_browsers as $browser)
                        <tr>
                            <td>{{$browser['browser']}}</td>
                            <td>{{$browser['sessions']}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>

        <!-- REPORT POR Visitors -->
        <div class="row">
            <header>
                <h4 style=" text-align: center">Usuários Visitantes Google Analytics - últimos 6 meses</h4>
            </header>
            <br><br>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td scope="col">Data</td>
                        <th scope="col">Visitantes</th>
                        <th scope="col">Páginas Visualizadas</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($relatorio_visitors as $visitor)
                        <tr>
                            <td>{{$visitor['date']}}</td>
                            <td>{{$visitor['visitors']}}</td>
                            <td>{{$visitor['pageViews']}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
</div>
</body>


</html>