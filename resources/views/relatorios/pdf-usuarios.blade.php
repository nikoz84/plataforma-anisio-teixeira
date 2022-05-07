<!DOCTYPE html>
<html lang="pt-br">

<head>
          <meta charset="UTF-8">
          <title>PDF de usuários</title>

          <style>
                    table,
                    td,
                    th {
                              border: 1px solid #ddd;
                              text-align: left;
                    }

                    table {
                              border-collapse: collapse;
                              width: 100%;
                    }

                    th{
                              padding: 16px;
                    }
                    td {
                              padding: 15px;
                    }

                    tr:nth-child(even) {
                              background-color: #f2f2f2;
                    }

                    th {
                              background-color: #6495ED;
                              color: white;
                    }
          </style>
</head>

<body>
          <div class="container">
                    <div class="">
                              <header>
                                        <h2 style=" text-align: center">LISTA DE USUÁRIOS</h2>
                              </header>
                              <br><br>

                              <div>
                                        <div class="table-responsive-md">
                                                  <table class="table">
                                                            <thead>
                                                                      <tr>
                                                                                <th>NOME</th>
                                                                                <th>FUNÇÃO</th>
                                                                                <th>QTD. CONTEÚDOS GERADOS</th>
                                                                                <th>STATUS</th>
                                                                      </tr>
                                                            </thead>
                                                            <tbody>
                                                                      @if(count($users))
                                                                      @foreach($users as $user)
                                                                      <tr>
                                                                                <?php ?>
                                                                                <td>{{$user->usuario}}</td>
                                                                                <td>{{$user->funcao}}</td>
                                                                                <td>{{$user->total_conteudo}}</td>
                                                                                <td>{{$user->is_active == 'true' ? 'ativo' : 'inativo'}}</td>
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