<!DOCTYPE html>
<html>
<head>
	<title>Conteudo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<style type="text/css">
		body {
			font-family:arial;
		}
		.atributos-arquivo {
			width:100%;
			padding-top:10px;
			padding-bottom:10px;
			background:#004893;
		}
		.atributos-arquivo ul {
			margin:0;
			padding:0;
			list-style:none;
			margin:0 auto;
			width:100%;
			text-align:center;
		}
		.atributos-arquivo ul li {
			color:white!important;
		}
		.atributos-arquivo ul li a {
			color:white!important;
			text-decoration:none;
		}
	</style>
</head>
<body>


	<video style="width:100%" controls>
	  <source src="storage/conteudos/conteudos-digitais/download/10409.mp4" type="video/mp4">
	  Your browser does not support HTML video.
	</video>

	<div class="atributos-arquivo">
		<ul>
			<li><a href="{{route('downloadFile.id', $id)}}"><i class="fa fa-download"></i> Baixar arquivo</a></li>
		</ul>
	</div>

	<br>

</body>
</html>