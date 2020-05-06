<base href="{{ URL::to('./') }}">
<style type="text/css">
	.div-center {
		width:95%;
		background:#f9f8f8;
		padding:10px;
		margin:0 auto;
		font-family:arial;
		text-align:center;
	}
	.logo-projeto img {
		display:block;
		width:100px;
		margin: auto;
	}
	.logo-projeto-rodape img {
		display:block;
		margin:0 auto;
		width:200px;
	}
</style>

<div class="div-center">
	<div class="logo-projeto">
		<img src="{{getenv('APP_URL')}}/img/icons-192.png">
	</div>
	<p>
	    Olá <strong>{{$user->name}}</strong>, 
	    por segurança da comunidade estamos verificando sua conta de email.
	<p>

	<p>
		Click para criar uma nova senha
	</p> 

	<a href="{{$dominio}}/api-v1/auth/verificar/{{$token}}" style="color:#3871c1!important">Criar nova senha</a>
    
    <br>
    <br>
    <br>
    <br>
	<div class="logo-projeto-rodape">
		<img src="{{getenv('APP_URL')}}/img/img-logomarca-rodape.png">
	</div>
</div>