@component('mail::message')
# Nuevo contratista | {{config('app.name')}}


Hola, 
{{$user_to->nombres}} {{$user_to->apellidos}}<br>
{{$user_to->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

Hemos enviado este correo para informarte que el usuario {{$user_form->nombres}} {{$user_form->apellidos}} está solicitando acceso por primera vez al aplicaivo.

<br>
@component('mail::button', ['url' => route('user.contractor.confirm.request', $user_form->documento)])
🔗 Ir
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
        'actionText' => 'Ir',
        'actionURL' => route('user.contractor.confirm.request', $user_form->documento),
    ]
)

@endslot

@endcomponent
