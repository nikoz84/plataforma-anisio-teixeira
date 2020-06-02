<!DOCTYPE html>
<html lang="pt-br">

<head>
          <meta charset="UTF-8">
          <title>PDF de Usuários</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
          <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
          <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
</head>

<body>
          <div class="container">
                    <div class="">
                              <header>
                                        <h2 style=" text-align: center">LISTA DE USUÁRIOS</h2>
                              </header>
                              <br><br>

                              <div class="panel panel-default">
                                        <div class="table-responsive-md">
                                                  <table class="table table-striped table-borderless">
                                                            <thead>
                                                                      <tr>
                                                                                <th>NOME</th>
                                                                                <th>FUNÇÃO</th>
                                                                                <th>QTD. CONTEÚDOS</th>
                                                                                <th>STATUS</th>
                                                                      </tr>
                                                            </thead>
                                                            <tbody>
                                                                      @if(count($users)))
                                                                      @foreach($users as $user)
                                                                      <tr>
                                                                                <?php ?>
                                                                                <td>{{$user->usuario}}</td>
                                                                                <td>{{$user->funcao}}</td>
                                                                                <td>{{$user->total_conteudo}}</td>
                                                                                <td>{{$user->is_active == 'true' ? 'Ativo' : 'Inativo'}}</td>
                                                                      </tr>
                                                                      @endforeach
                                                                      @else
                                                                                <tr>
                                                                                          <td colspan="4">Nenhum resgistro encontrado...</td>
                                                                                </tr>
                                                                      @endif
                                                            </tbody>
                                                  </table>
                                        </div>

                              </div>
                    </div>
          </div>
</body>


</html>