@component('mail::message')
# Solicitud de aprobación de fase | {{$proyecto->present()->proyectoNode()}}.

Señor(a)<br>
<b>_{{$proyecto->present()->proyectoUserAsesor()}}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informar que el experto {{$movimiento->usuario}} ha solicitado aprobar una fase del proyecto {{$proyecto->present()->proyectoName()}}.
<br>


@component('mail::promotion')
    <center>
        <h3 class="subtittle">Proyecto:</h3>
        <h3 class="subtittle-value">{{$proyecto->present()->proyectoCode()}} - {{$proyecto->present()->proyectoName()}}</h3>
        <h3 class="subtittle">Fase que se solicita aprobar: </h3>
        <h3 class="subtittle-value">{{$movimiento->fase}}</h3>
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
