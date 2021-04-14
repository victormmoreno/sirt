@component('mail::message')
# Se ha aceptado una idea para presentarse al comité | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Cordial Saludo.

<p align="justify">El articulador del nodo <b>{{$idea->nodo->entidad->nombre}}</b> ha aceptado una nueva idea de proyecto para presentar al comité de ideas.</p>

Por favor, tratar de realizar la debida gestión para realizar el comité.<br>

@component('mail::panel')
	
	<h1 class="tittle">📑 Información Idea</h1>
	
@endcomponent

@component('mail::promotion')
  <center>
      <h3 class="subtittle">Código Idea:</h3> 
      <h3 class="subtittle-value">{{$idea->codigo_idea}}</h3>
      <h3 class="subtittle">Nombre Idea de proyecto: </h3>
      <h3 class="subtittle-value">{{$idea->nombre_proyecto}}</h3>
      <h3 class="subtittle">Talento: </h3>
      <h3 class="subtittle-value">{{$idea->talento->user->nombres}} {{$idea->talento->user->apellidos}} - {{$idea->talento->user->email}}</h3>
      @if ($observaciones != null)
      <h2>El articulador dejó las siguientes observaciones</h2>
      <small align="justify"><strong>{{$observaciones}}</strong></small>
      @endif
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
