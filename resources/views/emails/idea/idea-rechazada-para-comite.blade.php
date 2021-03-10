@component('mail::message')
# Se le ha convocado para presentarse en un taller de fortalecimiento | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$idea->talento->user->nombres }} {{$idea->talento->user->apellidos }}_</b><br>
Cordial Saludo.

<p align="justify">El tecnoparque <b>{{$idea->nodo->entidad->nombre}}</b> le ha convocado a un taller de fortalecimiento.</p>

Ha recibido este mensaje porque Tecnoparque nodo {{$idea->nodo->entidad->nombre}} ha considerado que su idea tiene potencial para ser 
acompañada por la Red Tecnoparque.

<b>¿Qué significa esto?</b> Tecnoparque {{$idea->nodo->entidad->nombre}} ha considerado que, según la información diligenciada en el formulario de registro de idea, su idea 
podría ser acompañada por nosotros, sin embargo, requiere asistir a un taller de fortalecimiento de ideas.<br>

<b>¿Cuál es el siguiente paso a seguir?</b> En los próximo días se pondrá en contacto con usted una persona para ayudarle a fortalecer su idea de proyecto, esto con el fin de 
que puedas volver a postular la idea y tener mas posibilidades de que sea aceptada para presentarse al comité. <br> 

A continuación verás los motivos por los cuales el experto de tecnoparque consideró que su idea aún no está lista para pasar por un comité de ideas y debido a esto, 
se le ha convocado a un taller de fortalecimiento. <br>

{{$motivos}}

@component('mail::panel')
	
	<h1 class="tittle">📑 Información Idea</h1>
	
@endcomponent

@component('mail::promotion')
  <center>
      <h3 class="subtittle">Código Idea:</h3> 
      <h3 class="subtittle-value">{{$idea->codigo_idea}}</h3>
      <h3 class="subtittle">Nombre Idea de proyecto: </h3>
      <h3 class="subtittle-value">{{$idea->nombre_proyecto}}</h3>
  </center>
	
@endcomponent

@if( $idea->nodo->infocenter->isEmpty())
Para más información puede ocudir a las instalaciones de 🏬 <strong>Tecnoparque nodo {{$idea->nodo->entidad->nombre}}</strong> ubicado 
en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@else
Para más información puede contactarse al telefono ☎️  <b>{{ $idea->nodo->telefono}}</b> ext <b>{{ $idea->nodo->infocenter->last()->extension}}</b>, o ocudir a las 
instalaciones de 🏬 <strong>Tecnoparque nodo {{$idea->nodo->entidad->nombre}}</strong>  ubicado en {{$idea->nodo->direccion}} en 
{{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@endif


Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
