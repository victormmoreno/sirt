@component('mail::message')
# Resultados del Comité de Selección de Ideas

Hola,
<br>
 {{config('app.name')}}.

Cordial Saludo.

Hemos enviado este correo para informarte de la desición que se dió en el Comité de Selección de Ideas de Bases Tecnológicas.
<br>
Para conocer el resultado, debe abrir el archivo adjunto a este email.
<br>
Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:actionURL)',
    [
        'actionText' => 'Iniciar Sesión',
        'actionURL' => route('login'),
    ]
)

@endslot

@endcomponent
