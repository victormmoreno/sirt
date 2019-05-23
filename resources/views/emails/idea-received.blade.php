@component('mail::message')
# Nueva idea Recibida - {{$user->nombre_nodo}}

{{$user->nombre_completo}}, haz recibido una nueva idea al nodo

{{$idea->nombrec }} - {{$idea->apellidoc }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
