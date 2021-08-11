@component('mail::message')
# Aprobación fase de {{$fase}} | {{$data->present()->articulacionCode()}} - {{$data->present()->articulacionName()}}

Señor(a)<br>
<strong>_{{$user->present()->userFullName()}}_</strong><br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.

<p align="justify">El <b>articulador  {{$data->present()->articulacionPbtUserAsesor()}}</b> ha solicitado la aprobación de la fase de {{$fase}} de la articulación {{$data->present()->articulacionCode()}} - {{$data->present()->articulacionName()}}</p>


Sigue este link para aprobar la fase de {{$fase}}  de la articulación {{$data->present()->articulacionCode()}} - {{$data->present()->articulacionName()}}.

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
