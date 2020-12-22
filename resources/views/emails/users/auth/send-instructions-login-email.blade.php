@component('mail::message')
# Instrucciones de ingreso a {{config('app.name')}}

Señor(a)<br>
_<strong>{{$user->nombres}} {{$user->apellidos}}</strong>_<br>
Contratista de {{config('app.name')}}.

Cordial Saludo.

Te damos la bienvenida a la {{config('app.name')}}.

Hemos enviado este correo para informarte las instrucciones a seguir para completar el registro de tu usuario en el aplicativo.

Estas haciendo una solicitud para Tecnoparque Nodo {{$user->contratista->nodo->entidad->nombre}}.

Ahora debes esperar a que el administrador del aplicativo o el dinamizador de Nodo {{$user->contratista->nodo->entidad->nombre}} valide tus datos y active tu cuenta para acceder.

Estas son tu credenciales, con la cual podrás ingresar a la plataforma {{config('app.name')}}, una vez te activen tu cuenta.
@component('mail::panel')
     <h1 class="tittle">🔐 Credenciales Inicio de Sesión</h1>
@endcomponent


@component('mail::table')
	| Correo Electrónico | Contraseña |
	|--------------------|------------|
	| {{$user->email}}  | {{$password}} |
@endcomponent
Con las anteriores credenciales podrás iniciar sesión mediante el siguiente boton.
<br>
@component('mail::button', ['url' => route('login')])
🔗 Iniciar Sesión
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
        'actionText' => 'Iniciar Sesión',
        'actionURL' => route('login'),
    ]
)

@endslot
	
@endcomponent
   
