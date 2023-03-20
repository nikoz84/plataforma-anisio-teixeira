<!DOCTYPE html>
<html>

<head>
    <title>Upload - Doc</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body>
    <div class="container">

        <div class="panel panel-primary">

            <div class="panel-heading text-center mt-5">
                <h2>Upload de arquivos</h2>
            </div>
            <div>
                <a href="{{ route('file.doc') }}" type="button" class="btn btn-primary">
                    Voltar
                </a>
            </div>

            <div class="panel-body mt-5">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="folder">Pasta de destino:</label>
                        <select class="form-select" id="folder" name="folder">
                            <option value="">-- Selecione --</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder }}">{{ $folder }}</option>
                            @endforeach
                            <option value="novapasta">Nova pasta</option>
                        </select>
                    </div>

                    <div class="mb-3" id="inputOculto">
                        <div class="mb-3">
                            <label class="form-label" for="inputNewFolder">Crie uma nova pasta</label>
                            <input type="text" class="form-control" name="new_folder" value="{{ old('new_folder') }}"
                                placeholder="Nome da Nova Pasta">
                            @error('new_folder')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputFile">Arquivo:</label>
                        <input type="file" name="file" id="file"
                            class="form-control @error('file') is-invalid @enderror" multiple>
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#inputOculto').hide();
        $('#folder').change(function() {
            if ($('#folder').val() == 'novapasta') {
                $('#inputOculto').show();
            } else {
                $('#inputOculto').hide();
            }
        });
    });
</script>
