@component('mail::message')
# Programación para el Comité de Selección de Ideas | Tecnoparque Nodo {{$nodo}}.

Experto(a)
<br>
Cordial Saludo.
<br>
Dando respuesta al registro de idea para la Red Tecnoparque tenemos el gusto de informar la fecha y dirección donde se realizará el comité de selección de ideas.
Se dará un espacio de cinco minutos para presentar un pitch donde se evaluará claridad de la idea y/o la solución, grado de innovación,
impacto y equipo de trabajo. También se contara con un espacio de cinco minutos para preguntas del comité.
<br>
@component('mail::panel')

	<h1 class="tittle">📑 Programación para el Comité de Selección de Ideas</h1>

@endcomponent
<h4>Comité del día: {{$comite->fechacomite->isoFormat('LL')}}</h4>

<h5>Ideas que se presentarán en el comité</h5>
@component('mail::promotion')
    <center>
        @foreach ($comite->ideas as $idea)
            <h3 class="subtittle">Código Idea:</h3>
            <h3 class="subtittle-value">{{$idea->codigo_idea}}</h3>
            <h3 class="subtittle">Nombre Idea de proyecto: </h3>
            <h3 class="subtittle-value">{{$idea->nombre_proyecto}}</h3>
            <h3 class="subtittle">Lugar donde se realizará el comité: </h3>
            <h3 class="subtittle-value">{{$idea->pivot->direccion}}</h3>
            <h3 class="subtittle">Fecha y hora que se realizará el comité: </h3>
            <h3 class="subtittle-value">{{$comite->fechacomite->isoFormat('LL')}} a las {{$idea->pivot->hora}}</h3>
            @endforeach
    </center>
@endcomponent

<h5>Expertos que estarán presentes en el comité</h5>

@component('mail::promotion')
    <center>
        @foreach ($comite->evaluadores as $gestor)
            <h3 class="subtittle">Experto(a):</h3> 
            <h3 class="subtittle-value">{{$gestor->nombres}} {{$gestor->apellidos}}</h3>
            <h3 class="subtittle">Desde: </h3>
            <h3 class="subtittle-value">{{$gestor->pivot->hora_inicio}}</h3>
            <h3 class="subtittle">Hasta: </h3>
            <h3 class="subtittle-value">{{$gestor->pivot->hora_fin}}</h3>
        @endforeach
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
