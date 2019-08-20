@component('mail::message')


Cordial Saludo.

Ha recibido este mensaje porque hemos recibido una idea.


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
