@component('mail::message')
#  [Ticket ID: {{ $message['ticket'] }}] {{ $message['subject'] }}

Señor(a)<br>
<b>_{{ $message['name'] }} {{ $message['lastname'] }}_</b><br>


Esta es una confirmación automática para indicarle que su caso de soporte ha sido recibido y
aceptado por nuestro sistema

Recibirá una respuesta en un plazo no mayor de 60 minutos

Por favor recuerde envíar con el mayor detalle posible su requerimiento,
de esta manera nuestro equipo técnico trabajará de manera mas eficiente.


@component('mail::panel')

	<h1 class="tittle">[Ticket ID: {{ $message['ticket'] }}]</h1>

@endcomponent

@component('mail::promotion')
***Asunto:*** {{$message['subject']}}

***Tipo Solicitud:*** {{$message['difficulty']}}

***Estado:*** {{$message['status']}}

***Descripción:***  {{$message['description']}}
@endcomponent


Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
