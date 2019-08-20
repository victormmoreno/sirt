@component('mail::message')
# Su idea fue recibida | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>{{$idea->nombres_contacto }} {{$idea->apellidos_contacto }}</b><br>
Cordial Saludo.

<p align="justify">El <b>SENA</b> te da la bienvenida a su programa {{config('app.name')}}, ahora podrás acceder a los servicios que la red ofrece para tí.</p>

Ha recibido este mensaje porque hemos recibido una idea, la cual fue asocida a Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.<br>



@component('mail::panel')
	
	<h1 class="tittle">Información Idea</h1>
	
@endcomponent

@component('mail::promotion')
  <center>
      <h3 class="subtittle">Código Idea:</h3> 
      <h3 class="subtittle-value">{{$idea->codigo_idea}}</h3>
      <h3 class="subtittle">Nombre Idea de proyecto: </h3>
      <h3 class="subtittle-value">{{$idea->nombre_proyecto}}</h3>
      <h2>Descripción</h2>
      <small align="justify"><strong>{{$idea->descripcion}}</strong></small>
  </center>
	
@endcomponent

Para más información puede contactarse al telefono <b>{{ $idea->nodo->infocenter->last()->extension}}</b>, o ocudir a las instalaciones de Tecnoparque nodo {{$idea->nodo->entidad->nombre}} ubicado en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).

Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
