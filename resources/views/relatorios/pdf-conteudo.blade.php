<!DOCTYPE html>
<html lang="pt-br">

<head>
          <meta charset="UTF-8">
          <title>PDF de conteúdos digitais</title>

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
                                        <h2 style=" text-align: center">{{$title}}</h2>
                              </header>
                              <br><br>

                              <div>
                                        <div class="table-responsive-md">
                                                  <table class="table">
                                                            <thead>
                                                                      <tr>
                                                                                <th>TÍTULO</th>
                                                                                <th>TIPO</th>
                                                                                <th>AUTOR</th>
                                                                                <th>QTD. {{$flag}}</th>
                                                                      </tr>
                                                            </thead>
                                                            <tbody>
                                                                      @if(count($contents))
                                                                      @foreach($contents as $content)
                                                                      <tr>
                                                                                <?php ?>
                                                                                <td>{{mb_strimwidth($content->title, 0, 50, "...")}}</td>
                                                                                <td>{{$content->type}}</td>
                                                                                <td>{{$content->authors}}</td>
                                                                                <td>{{number_format($content->quantity,0,".",".")}}</td>
                                                                      </tr>
                                                                      @endforeach
                                                                      @else
                                                                      <tr>
                                                                                <td colspan="5">Nenhum resgistro encontrado...</td>
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