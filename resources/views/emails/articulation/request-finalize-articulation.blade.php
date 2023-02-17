@component('mail::message')
# Solicitud de aval | {{$notification->notificable->present()->articulationCode()}}.

Señor(a)<br>
<b>_{{$notification->receptor->nombres.' '.$notification->receptor->apellidos}}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informar que el señor(a) {{$notification->rol_remitente->name}} {{$notification->remitente->nombres .' '. $notification->remitente->apellidos}} ha solicitado
aprobar el aval para finalizar la {{__('articulation')}} {{$notification->notificable->present()->articulationName()}}.
<br>


@component('mail::promotion')
    <center>
        <h3 class="subtittle">{{__('articulation')}}</h3>
        <h3 class="subtittle-value">{{$notification->notificable->present()->articulationCode()}} - {{$notification->notificable->present()->articulationName()}}</h3>
        <h3 class="subtittle">{{ __('Status') }}</h3>
        <h3 class="subtittle-value">{{$notification->notificable->present()->articulationPhase()}}</h3>
    </center>
@endcomponent

@component('mail::button', ['url' => route('articulations.show',  $notification->notificable)])
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
        'actionURL' => route('articulations.show',  $notification->notificable),
    ]
)

@endslot

@endcomponent

