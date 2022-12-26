@component('mail::message')
# Notificación de cambio de nodo {{config('app.name')}}

<br>
Hola, 
{{$user->nombres}} {{$user->apellidos}}<br>
{{$user->getRoleNames()->implode(', ')}} 

Cordial Saludo.

Hemos enviado este correo para informarle que su cuenta fue asignada a un nuevo nodo.

@component('mail::panel')
	
	<h1 class="tittle">Nodos asociados a su cuenta</h1>
	
@endcomponent

@component('mail::promotion')
    <center>
        
        @if($user->isUserDinamizador())
            <h3 class="subtittle">{{App\User::IsDinamizador()}}:</h3> 
            <h3 class="subtittle-value">{{$user->present()->userDinamizadorNombreNodo()}}</h3>
        @endif
        @if($user->isUserExperto() || $user->isUserArticulador())
            @if($user->isUserExperto())
                <h3 class="subtittle">{{App\User::IsGestor()}}:</h3> 
            @else
                <h3 class="subtittle">{{App\User::IsArticulador()}}:</h3> 
            @endif
                <h3 class="subtittle-value">{{$user->present()->userGestorNombreNodo()}}</h3>
        @endif
        @if($user->isUserInfocenter())
        <h3 class="subtittle">{{App\User::IsInfocenter()}}:</h3> 
        <h3 class="subtittle-value">{{$user->present()->userInfocenterNombreNodo()}}</h3>
        @endif
        @if($user->isUserIngreso())
            <h3 class="subtittle">{{App\User::IsIngreso()}}:</h3> 
            <h3 class="subtittle-value">{{$user->present()->userIngresoNombreNodo()}}</h3>
        @endif
    </center>
	
@endcomponent
<br>
Gracias,<br>
<strong>_{{config('mail.from.name')}}_</strong> <br>
Gestión {{ config('app.name') }} 💯


@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>
@endslot

@endcomponent
