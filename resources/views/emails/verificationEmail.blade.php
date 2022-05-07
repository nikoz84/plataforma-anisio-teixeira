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
	.logo-projeto h3 {
		color:#3871c1;
		padding-bottom:10px;
		border-bottom:1px solid #cc2726;
	}
</style>

<div class="div-center">
	<div class="logo-projeto">
		<img src="{{env('APP_URL')}}/img/icons-192.png">
		<h3>{{getenv('APP_NAME')}}</h3>
	</div>
	<p>
	    Olá <strong>{{$user->name}}</strong>, 
	    por segurança da comunidade estamos verificando sua conta de email.
	<p>
    
    @if ($option && $option == 'recoverPass')
		<p>
			Click para criar uma nova senha
		</p> 

		<a href="{{$dominio}}/usuario/mudar-senha/{{$token}}" style="color:#3871c1!important">
		    Criar nova senha
	    </a>
    @endif

    @if ($option && $option == 'register')
        <p>
			Com o seguinte código cole no campo de verificação
		</p> 
		Código de verificação:
		<strong style="color:#3871c1!important">
		    {{ $token }}
	    </strong>
    @endif

    <br>
    <br>
    <br>
    <br>
	<div class="logo-projeto-rodape">
		<img src="{{env('APP_URL')}}/img/img-logomarca-rodape.png">
	</div>
</div>