@component('mail::message')
# Resultados del Comité de Selección de Ideas | Tecnoparque Nodo {{$datosIdea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$datosIdea->nombres_contacto }} {{$datosIdea->apellidos_contacto }}_</b><br>
Cordial Saludo.

@component('mail::panel')
	
	<h1 class="tittle">📑 Resultados del Comité de Selección de Ideas</h1>
	
@endcomponent

Hemos enviado este correo para informarte de la decisión que se dió en el Comité de Selección de Ideas de Bases Tecnológicas.
<br>
Para conocer el resultado, debe abrir el archivo adjunto a este email.
<br>

@if( $datosIdea->nodo->infocenter->isEmpty())
Para más información puede ocudir a las instalaciones de Tecnoparque nodo {{$datosIdea->nodo->entidad->nombre}} ubicado en {{$datosIdea->nodo->direccion}} en {{$datosIdea->nodo->entidad->ciudad->nombre}} ({{$datosIdea->nodo->entidad->ciudad->departamento->nombre}}).
@else
Para más información puede contactarse al telefono ☎️  <b>{{ $datosIdea->nodo->telefono}}</b> ext <b>{{ $extensiones }}</b>o acudir a las instalaciones de 🏬 <strong>Tecnoparque nodo {{$datosIdea->nodo->entidad->nombre}}</strong>  ubicado en {{$datosIdea->nodo->direccion}} en {{$datosIdea->nodo->entidad->ciudad->nombre}} ({{$datosIdea->nodo->entidad->ciudad->departamento->nombre}}).
@endif

Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>



@endslot

@endcomponent
