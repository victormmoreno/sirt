@component('mail::message')
# Su idea fue recibida {{$user->nombrenodo}}

{{$user->nombre_completo}}

Cordial Saludo.

Ha recibido este mensaje porque hemos recibido una idea.


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
