@component('mail::message')
# Solicitud de aprobación de fase | {{$notificacion->notificable->present()->proyectoNode()}}.

Señor(a)<br>
<b>_{{$notificacion->receptor->nombres.' '.$notificacion->receptor->apellidos}}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informar que el experto {{$notificacion->remitente->nombres .' '. $notificacion->remitente->apellidos}} ha solicitado
aprobar la fase de {{$notificacion->fase->nombre}} del proyecto {{$notificacion->notificable->present()->proyectoName()}}.
<br>


@component('mail::promotion')
    <center>
        <h3 class="subtittle">Proyecto:</h3>
        <h3 class="subtittle-value">{{$notificacion->notificable->present()->proyectoCode()}} - {{$notificacion->notificable->present()->proyectoName()}}</h3>
        <h3 class="subtittle">Fase que se solicita aprobar:</h3>
        <h3 class="subtittle-value">{{$notificacion->fase->nombre}}</h3>
    </center>
@endcomponent

@php
    if ($notificacion->fase->nombre == $notificacion->notificable->IsSuspendido()) {
        $url = route('proyecto.suspender', $notificacion->notificable->id);
    } else {
        $url = $notificacion->notificable->present()->proyectoRutaActual();
    }
@endphp
@component('mail::button', ['url' => $url])
🔗 Ir a la página para aprobar el cambio de fase
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
        'actionURL' => $url,
    ]
)

@endslot

@endcomponent
