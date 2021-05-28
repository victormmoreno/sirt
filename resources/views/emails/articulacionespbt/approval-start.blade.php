@component('mail::message')
# Aprobación fase de {{$fase}} | {{$data->actividad->codigo_actividad}} - {{$data->actividad->nombre}}

Señor(a)<br>
<strong>_{{$user->nombres}} {{$user->apellidos}}_</strong><br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

<p align="justify">El <b>articulador  {{$data->actividad->gestor->user->nombres}} {{$data->actividad->gestor->user->apellidos}}</b> ha solicitado la aprobación de la fase de {{$fase}} de la articulación {{$data->actividad->codigo_actividad}} - {{$data->actividad->nombre}}</p>


Sigue este link para aprobar la fase de {{$fase}}  de la articulación {{$data->actividad->codigo_actividad}} - {{$data->actividad->nombre}}.

@component('mail::panel')
    <h1 class="tittle">✔️ Aprobar la fase de {{$fase}}</h1>
@endcomponent

@component('mail::button', ['url' => route("articulacion.show.{$fase}",$data->id )])
🔗 Aprobar la fase de {{$fase}}
@endcomponent


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