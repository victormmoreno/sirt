@component('mail::message')
# Contraseña de ingreso a {{config('app.name')}}

Hola, 
{{$user->nombres}}<br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

Hemos enviado este correo para informarte tu contraseña asiginada, con la cual podrás ingresar al sistema {{config('app.name')}}


@component('mail::table')
	| Correo Electrónico | Contraseña |
	|--------------------|------------|
	| {{$user->email}}  | {{$password}} |
@endcomponent
Con las anteriores credenciales podrás iniciar sesión mediante el siguiente boton.
<br>
@component('mail::button', ['url' => route('login')])
Iniciar Sesión
@endcomponent

Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:actionURL)',
    [
        'actionText' => 'Iniciar Sesión',
        'actionURL' => route('login'),
    ]
)

@endslot
	
@endcomponent
   