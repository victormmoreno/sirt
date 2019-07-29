@component('mail::message')
# Contraseña cambiada 

Hola, 
{{$user->nombres}} {{$user->apellidos}}<br>
{{$user->getRoleNames()->implode(', ')}} {{config('app.name')}}.

Cordial Saludo.


La contraseña para su cuenta de {{config('app.name')}} en {{config('app.url')}} se ha cambiado con éxito.

Si no inició este cambio, comuníquese con su administrador inmediatamente.

Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
@endslot
@endcomponent
