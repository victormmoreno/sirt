@component('mail::message')
# Solicitud de aprobación de fase | Tecnoparque Nodo {{$proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$proyecto->articulacion_proyecto->actividad->gestor->user->nombres }} {{$proyecto->articulacion_proyecto->actividad->gestor->user->apellidos }}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informar que el experto {{$movimiento->usuario}} ha solicitado aprobar una fase del proyecto {{$proyecto->articulacion_proyecto->actividad->nombre}}.
<br>
{{-- @component('mail::panel')
	
	<h1 class="tittle">Se aprobó la fase {{$movimiento->fase}} del proyecto {{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}</h1>
	
@endcomponent --}}

@component('mail::promotion')
  <center>
      <h3 class="subtittle">Proyecto:</h3> 
      <h3 class="subtittle-value">{{$proyecto->articulacion_proyecto->actividad->codigo_actividad}} - {{$proyecto->articulacion_proyecto->actividad->nombre}}</h3>
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
