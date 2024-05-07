@component('mail::message')
# Encuesta de Satisfaccion {{class_basename($query)}} | {{$query->code}}.

Señor(a)<br>
<b>_{{$notifiable->nombres.' '.$notifiable->apellidos}}_</b><br>
Cordial Saludo.
<br>
Ha recibido este mensaje porque se solicitó diligenciar la encuesta de satisfaccion de {{class_basename($query)}} {{$query->code}}.

@component('mail::promotion')
    <center>
        <h3 class="subtittle">{{class_basename($query)}}</h3>
        <h3 class="subtittle-value">{{$query->code}} - {{$query->name}}</h3>
    </center>
@endcomponent

@component('mail::button', [
    'url' => url(config('app.url').route('encuesta.formulario', [
                        'id' => $query->id,'module' => 'articulacion', 'token' => $token
                ],false))
    ])
🔗 Realizar Encuesta
@endcomponent

Recuerde que esta encuesta debe ser diligenciada con el fin de avanzar a la siguiente fase.
<br>

Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:actionURL)',
    [
        'actionText' => 'Ir a la página para realizar la encuesta',
        'actionURL' => url(config('app.url').route('encuesta.formulario', [
                        'id' => $query->id,'module' => 'articulacion', 'token' => $token
                ],false)),
    ]
)

@endslot

@endcomponent
