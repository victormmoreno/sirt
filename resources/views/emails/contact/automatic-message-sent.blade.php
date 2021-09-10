@component('mail::message')
#  [Ticket ID: {{ $contact->ticket }}] {{ $contact->subject }}

Señor(a)<br>
<b>_{{ $contact->name }} {{ $contact->lastname }}_</b><br>

<br>
Esta es una confirmación automática para indicarle que su caso de soporte ha sido recibido y aceptado por nuestro sistema

Recibirá una respuesta en un plazo no mayor de 60 minutos

Por favor recuerde envíar con el mayor detalle posible su requerimiento, de esta manera nuestro equipo tecnico trabajara de manera mas eficiente

Subject: Sin acceso a la base de datos
Priority: Media
Status: Abierto
<br>
@component('mail::panel')

	<h1 class="tittle">Se aprobó la fase asdasd</h1>

@endcomponent

@component('mail::promotion')

@endcomponent


Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
