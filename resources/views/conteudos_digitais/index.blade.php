<!DOCTYPE html>
<html>
<head>
	<title>Conteudo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<style type="text/css">
		body {
			font-family:arial;
			padding:0;
			margin:0;
		}
		.atributos-arquivo {
			width:100%;
			padding-top:10px;
			padding-bottom:10px;
			background:#004893;
		}
		.atributos-arquivo ul {
			margin:0 auto;
			padding:0;
			list-style:none;
			margin:0 auto;
			width:100%;
			text-align:center;
			width:360px;
			font-size:14px;
		}
		.atributos-arquivo ul li {
			color:white!important;
			float:left;
			display: block;
			margin-left:15px;

		}
		.atributos-arquivo ul li a {
			color:white!important;
			text-decoration:none;
		}
	</style>
</head>
<body>

	<video style="width:100%" controls>
	  <source src="{{$download}}" type="{{ $mime_type }}">
	  Your browser does not support HTML video.
	</video>

	<div class="atributos-arquivo">
		<ul>
			<li title="Baixar Arquivo!">
				<a href="{{url("/api-v1/files/download/$id")}}"><i class="fa fa-download"></i> Baixar arquivo</a>
			</li>

			<li title="Tamanho do Arquivo!"><i class="fas fa-hdd"></i> {{ $mega_bytes }} MB</li>

			<li title="Formato .{{ $formato }}">
				@if ($tipo == 5)
				    <i class="far fa-file-video"></i>
				@else
				    <i class="fas fa-file-audio"></i>
				@endif
				.{{$formato}}
			</li>
		</ul>

		<div style="clear:both;"></div>
	</div>

	<br>

</body>
</html>