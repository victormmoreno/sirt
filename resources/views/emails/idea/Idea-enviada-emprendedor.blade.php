@component('mail::message')
# Su idea fue recibida | {{$idea->nodo->entidad->nombre}}.

Señor(a) <b>{{$idea->nombres_contacto }} {{$idea->apellidos_contacto }}</b><br>
Cordial Saludo.

Ha recibido este mensaje porque hemos recibido una idea, la cual fue asocida a Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}

@component('mail::table')
	| Código Idea | {{$idea->codigo_idea}} |
	||------------|
	| Nombre Idea de proyecto | {{$idea->nombre_proyecto}} |


	
|:-:|:------:|
|  Código Idea  | {{$idea->codigo_idea}}  |
|  Nombre Idea de proyecto |  {{$idea->nombre_proyecto}}  |
|:-:|:------:|


@endcomponent



{{ $idea->nodo->infocenter->each(function($item){
      var_dump($item->toArray());
     })}}

Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
