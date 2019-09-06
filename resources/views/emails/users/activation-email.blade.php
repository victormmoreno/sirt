@component('mail::message')
# Activación de cuenta para ingresar a {{config('app.name')}}

Señor(a)<br>
<strong>_{{$user->nombres}} {{$user->apellidos}}_</strong><br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

<p align="justify">El <b>SENA</b> te da la bienvenida a su programa {{config('app.name')}}, ahora eres un usuario de la plataforma.</p>


Sigue este link para activar tu cuenta.

@component('mail::panel')
    <h1 class="tittle">✔️ Activación de cuenta</h1>
@endcomponent

@component('mail::button', ['url' => route('activation', $user->token)])
🔗 Activa tu cuenta
@endcomponent

Si no lo haces no podrás ingresar a la plataforma {{config('app.name')}}.

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
        'actionText' => 'Activa tu cuenta',
        'actionURL' => route('activation', $user->token),
    ]
)

@endslot
@endcomponent
