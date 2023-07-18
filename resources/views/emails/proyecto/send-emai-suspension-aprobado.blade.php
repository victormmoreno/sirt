@component('mail::message')
# Cancelación de proyecto | {{$proyecto->present()->proyectoNode()}}.

Dinamizador(a)<br>
Cordial Saludo.
<br>
Se ha enviado este correo para informarte que el {{$movimiento->rol}} 
{{$movimiento->usuario}} solicita cancelar el proyecto.
<br>
@component('mail::panel')

	<h1 class="tittle">Se solicita aprobar un cambio de fase</h1>

@endcomponent

@component('mail::promotion')
    <center>
        <h3 class="subtittle">Proyecto:</h3>
        <h3 class="subtittle-value">{{$proyecto->present()->proyectoCode()}} - {{$proyecto->present()->proyectoName()}}</h3>
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
