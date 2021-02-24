@component('mail::message')
# Confirmación acceso a {{config('app.name')}}

<br>
Hola, 
{{$user->nombres}} {{$user->apellidos}}<br>
{{$user->getRoleNames()->implode(', ')}} {{$user->present()->userGestorNombreNodo()}}

Cordial Saludo.

Hemos enviado este correo para informarte que ya fue vericada tu información y habilitada tu cuenta, ahora puedes ingresar a través de {{route('login')}} o presionando el siguiente botón.

<br>
@component('mail::button', ['url' => route('login')])
🔗 Iniciar Sesión
@endcomponent

Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


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
