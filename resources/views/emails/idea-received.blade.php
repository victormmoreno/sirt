@component('mail::message')
# Nueva idea Recibida

Sra Matha, haz recibido una nueva idea al nodo

{{$idea->nombrec }} - {{$idea->apellidoc }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
