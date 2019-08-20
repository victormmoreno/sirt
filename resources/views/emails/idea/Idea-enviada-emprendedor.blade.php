@component('mail::message')
# Su idea fue recibida | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>{{$idea->nombres_contacto }} {{$idea->apellidos_contacto }}</b><br>
Cordial Saludo.

Ha recibido este mensaje porque hemos recibido una idea, la cual fue asocida a Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}


@component('mail::panel')
	información Idea
@endcomponent

@component('mail::promotion')
  <center>
      <h2>Código Idea: <strong>{{$idea->codigo_idea}}</strong></h2>
      <h3>Nombre Idea de proyecto: <strong>{{$idea->nombre_proyecto}}</strong></h3>
      <h2>Descripción</h2>
      <small align="justify"><strong>{{$idea->descripcion}}</strong></small>
  </center>
	
@endcomponent

Para más información puede contactarse al telefono <b>{{ $idea->nodo->infocenter->last()->extension}}</b>.



Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
