@component('mail::message')
# Activación de cuenta para ingresar a {{config('app.name')}}

Hola, 
{{$user->nombres}} {{$user->apellidos}}<br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

Sigue este link para activar tu cuenta.

@component('mail::button', ['url' => route('activation', $user->token)])
Activa tu cuenta
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
        'actionText' => 'Activa tu cuenta',
        'actionURL' => route('activation', $user->token),
    ]
)

@endslot
	

@endcomponent
