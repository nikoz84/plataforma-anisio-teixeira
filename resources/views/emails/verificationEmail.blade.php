<p>
    Olá <strong>{{ $user->name }}</strong>, 
    por segurança da comunidade estamos verificando sua conta de email.
<p>

<p>
	Click neste link para criar uma nova senha: 
	<a href="{{$dominio}}/auth/verificar/{{$token}}">Trocar senha</a>
</p>
