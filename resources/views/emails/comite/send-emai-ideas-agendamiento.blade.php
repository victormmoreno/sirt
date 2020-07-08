@component('mail::message')
# Programación para el Comité de Selección de Ideas | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$idea->nombres_contacto }} {{$idea->apellidos_contacto }}_</b><br>
Cordial Saludo.
<br>
Se ha enviado este correo para informarte la fecha y dirección donde se realizará el comité de selección de ideas.
<br>
@component('mail::panel')
	
	<h1 class="tittle">📑 Programación para el Comité de Selección de Ideas</h1>
	
@endcomponent

@component('mail::promotion')
  <center>
      <h3 class="subtittle">Código Idea:</h3> 
      <h3 class="subtittle-value">{{$idea->codigo_idea}}</h3>
      <h3 class="subtittle">Nombre Idea de proyecto: </h3>
      <h3 class="subtittle-value">{{$idea->nombre_proyecto}}</h3>
      <h3 class="subtittle">Lugar donde se realizará el comité: </h3>
      <h3 class="subtittle-value">{{$idea->comites()->wherePivot('comite_id', $comite->id)->first()->pivot->direccion}}</h3>
      <h3 class="subtittle">Fecha y hora que se realizará el comité: </h3>
      <h3 class="subtittle-value">{{$comite->fechacomite->isoFormat('LL')}} a las {{$idea->comites()->wherePivot('comite_id', $comite->id)->first()->pivot->hora}}</h3>
  </center>
	
@endcomponent

@if( $idea->nodo->infocenter->isEmpty())
Para más información puede ocudir a las instalaciones de Tecnoparque nodo {{$idea->nodo->entidad->nombre}} ubicado en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@else
Para más información puede contactarse al telefono ☎️  <b>{{ $idea->nodo->telefono}}</b> ext <b>{{ $idea->nodo->infocenter->last()->extension}}</b>, o ocudir a las instalaciones de 🏬 <strong>Tecnoparque nodo {{$idea->nodo->entidad->nombre}}</strong>  ubicado en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@endif

Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>



@endslot

@endcomponent
