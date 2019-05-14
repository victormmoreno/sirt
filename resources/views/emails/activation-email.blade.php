@component('mail::message')
# Activación de cuenta

Sigue este link para activar tu cuenta.

@component('mail::button', ['url' => route('actuvation', $user->token)])
Activa tu cuenta
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
