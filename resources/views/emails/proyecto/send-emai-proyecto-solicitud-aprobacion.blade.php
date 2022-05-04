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
        <h3 class="subtittle">Fase que se solicita aprobar: </h3>
        <h3 class="subtittle-value">{{$notificacion->notificable->fase->nombre}}</h3>
    </center>
@endcomponent


Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
