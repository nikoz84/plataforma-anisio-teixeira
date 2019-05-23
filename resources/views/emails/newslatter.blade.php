@component('mail::message')
# Boletim informativo

Veja os últimos conteúdos do mês

- [Conteudo n1](http://des.pat)
- [Conteudo n2](http://des.pat)
- [Conteudo n3](http://des.pat)

@component('mail::button', ['url' => '/'])
    Leia em nosso site
@endcomponent

Obrigado,<br>
equipe {{ config('app.name') }}
@endcomponent