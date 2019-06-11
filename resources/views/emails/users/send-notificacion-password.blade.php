@component('mail::message')
# Bienvenido {{$user->nombre_completo}}

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
