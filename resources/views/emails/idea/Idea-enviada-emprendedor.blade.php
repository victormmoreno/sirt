@component('mail::message')
# Su idea fue postulada | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$idea->talento->user->nombres }} {{$idea->talento->user->apellidos }}_</b><br>
Cordial Saludo.

Ha recibido este mensaje porque hemos recibido la postulación de su idea, la cual fue asocida a Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.<br>

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
Para más información puede ocudir a las instalaciones de 🏬 <strong>Tecnoparque nodo {{$idea->nodo->entidad->nombre}}</strong> ubicado en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@else
Para más información puede contactarse al telefono ☎️  <b>{{ $idea->nodo->telefono}}</b> ext <b><pre>{{ collect($idea->nodo->infocenter)->last()->extension}}</pre></b>, o ocudir a las instalaciones de 🏬 <strong>Tecnoparque nodo {{$idea->nodo->entidad->nombre}}</strong>  ubicado en {{$idea->nodo->direccion}} en {{$idea->nodo->entidad->ciudad->nombre}} ({{$idea->nodo->entidad->ciudad->departamento->nombre}}).
@endif


Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
