@component('mail::message')
# Solicitud de aprobación | {{$notification->notificable->present()->accompanimentCode()}}.

Señor(a)<br>
<b>_{{$notification->receptor->nombres.' '.$notification->receptor->apellidos}}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informar que el articulador {{$notification->remitente->nombres .' '. $notification->remitente->apellidos}} ha solicitado
aprobar la {{__('Accompaniments')}} {{$notification->notificable->present()->accompanimentName()}}.
<br>


@component('mail::promotion')
    <center>
        <h3 class="subtittle">{{__('Accompaniments')}}</h3>
        <h3 class="subtittle-value">{{$notification->notificable->present()->accompanimentCode()}} - {{$notification->notificable->present()->accompanimentName()}}</h3>
        <h3 class="subtittle">{{ __('Status') }}</h3>
        <h3 class="subtittle-value">{{$notification->notificable->present()->accompanimentStatus()}}</h3>
    </center>
@endcomponent

@component('mail::button', ['url' => route('accompaniments.show',  $notification->notificable)])
🔗 Ir a la página para aprobar
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
        'actionText' => 'Ir a la página para aprobar el cambio de fase',
        'actionURL' => route('accompaniments.show',  $notification->notificable),
    ]
)

@endslot

@endcomponent

