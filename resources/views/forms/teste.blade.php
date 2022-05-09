{{ Form::open(['url' => 'form', 'method' => 'get']) }}
    {{  Form::text('email', 'example@gmail.com') }}
    {{ Form::submit('Click Me!') }}
{{ Form::close() }}