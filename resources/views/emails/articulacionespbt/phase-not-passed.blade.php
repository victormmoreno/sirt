@component('mail::message')
# No se aprobó la fase de la articulación | Tecnoparque Nodo {{$articulacion->present()->articulacionPbtNodo()}}.

Señor(a)<br>
<b>_{{$articulacion->present()->articulacionPbtUserAsesor() }}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informarte que el {{$movimiento->role->name}} {{$movimiento->movimiento->movimiento}} una fase de la articulación.
<br>
@component('mail::panel')
	<h1 class="tittle">No se aprobó la fase {{$fase}} de la articulación {{$articulacion->present()->articulacionCode()}}</h1>
@endcomponent

@component('mail::promotion')
    <center>
        <h3 class="subtittle">Articulación:</h3>
        <h3 class="subtittle-value">{{$articulacion->present()->articulacionCode()}} - {{$articulacion->present()->articulacionName()}}</h3>
        <h3 class="subtittle">Fase que no se aprobó: </h3>
        <h3 class="subtittle-value">{{$fase}}</h3>
        <h3 class="subtittle">Motivos por los que no se aprobó: </h3>
        <h3 class="subtittle-value">{{$movimiento->comentarios}}</h3>
        <h3 class="subtittle">Persona que NO aprobó la fase: </h3>
        <h3 class="subtittle-value">{{$movimiento->user->present()->userFullName()}}  ({{$movimiento->role->name}})</h3>
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
