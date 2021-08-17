@component('mail::message')
# No se aprobó la fase del proyecto | {{$proyecto->present()->proyectoNode()}}.

Señor(a)<br>
<b>_{{$proyecto->present()->proyectoUserAsesor()}}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informarte que el {{$movimiento->rol}} {{$movimiento->movimiento}} una fase del proyecto.
<br>
@component('mail::panel')

	<h1 class="tittle">No se aprobó la fase {{$movimiento->fase}} del proyecto {{$proyecto->present()->proyectoName()}}</h1>

@endcomponent

@component('mail::promotion')
    <center>
        <h3 class="subtittle">Proyecto:</h3>
        <h3 class="subtittle-value">{{$proyecto->present()->proyectoCode()}} - {{$proyecto->present()->proyectoName()}}</h3>
        <h3 class="subtittle">Fase que no se aprobó: </h3>
        <h3 class="subtittle-value">{{$movimiento->fase}}</h3>
        <h3 class="subtittle">Motivos por los que no se aprobó: </h3>
        <h3 class="subtittle-value">{{$movimiento->comentarios}}</h3>
        <h3 class="subtittle">Persona que NO aprobó la fase: </h3>
        <h3 class="subtittle-value">{{$movimiento->usuario}} ({{$movimiento->rol}})</h3>
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
