@component('mail::message')
# Resultados del Comité de Selección de Ideas | Tecnoparque {{$datosIdea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>_{{$datosIdea->user->nombres }} {{$datosIdea->user->apellidos }}_</b><br>
Cordial Saludo.

@component('mail::panel')
	
	<h1 class="tittle">📑 Resultados del Comité de Selección de Ideas</h1>
	
@endcomponent

Se ha enviado este correo para informarte de la decisión que se dió en el Comité de Selección de Ideas de Bases Tecnológicas.
<br>
Para conocer el resultado, debe abrir el archivo adjunto a este email.
<br>

Para más información puede contactarse con el nodo de las siguientes formas: <br>
@if (isset($datosIdea->nodo->entidad->email_entidad))
Email 📧: <b> {{ $datosIdea->nodo->entidad->email_entidad }}. </b> <br>
@endif
@if (isset($datosIdea->nodo->telefono))
Teléfono ☎️: <b>{{ $datosIdea->nodo->telefono }}</b>{!! isset($datosIdea->nodo->extension) ? ' ext <b>' . $datosIdea->nodo->extension . '</b>' : '' !!}. <br>
@endif
@if (isset($datosIdea->nodo->direccion))
Acudir a las instalaciones de 🏬 <strong>Tecnoparque {{$datosIdea->nodo->entidad->nombre}}</strong>  ubicado en {{$datosIdea->nodo->direccion}} en {{$datosIdea->nodo->entidad->ciudad->nombre}} ({{$datosIdea->nodo->entidad->ciudad->departamento->nombre}}). <br>
@endif

Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>



@endslot

@endcomponent
