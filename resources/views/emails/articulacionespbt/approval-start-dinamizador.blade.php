@component('mail::message')
# Aprobación fase de {{$fase}} | {{$data->present()->articulacionCode()}} - {{$data->present()->articulacionName()}}

Cordial Saludo.

<p align="justify">El <b> {{$movimiento->role->name}}  {{$talent->present()->userFullName()}}</b> ha aprobado la fase de {{$fase}} de la articulación {{$data->present()->articulacionCode()}} - {{$data->present()->articulacionName()}}</p>


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
        'actionText' => "Aprobar la fase de {$fase}",
        'actionURL' => route("articulacion.show.{$fase}",$data->id),
    ]
)
@endslot
@endcomponent
