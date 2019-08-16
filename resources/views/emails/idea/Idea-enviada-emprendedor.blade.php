@component('mail::message')
# Su idea fue recibida | Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}.

Señor(a)<br>
<b>{{$idea->nombres_contacto }} {{$idea->apellidos_contacto }}</b><br>
Cordial Saludo.

Ha recibido este mensaje porque hemos recibido una idea, la cual fue asocida a Tecnoparque Nodo {{$idea->nodo->entidad->nombre}}

@component('mail::table')
	| Código Idea | {{$idea->codigo_idea}} |
	||------------|
	| Nombre Idea de proyecto | {{$idea->nombre_proyecto}} |



@endcomponent

@component('mail::panel')
	
	asdasasfasdfasfsdf
@endcomponent

@component('mail::promotion')
	<h3 >Código Idea: </h3>{{$idea->codigo_idea}}
<table class="table table-striped">
  
  <tbody>
    <tr>
      <td><b>Código Idea</b></td>
      <td>{{$idea->codigo_idea}}</td>
    
    </tr>
    <tr>
      <td>Nombre Idea de proyecto </td>
      <td>{{$idea->nombre_proyecto}}</td>
    </tr>
    <tr>
      <td>Larry</td>
      <td>the Bird</td>
    </tr>
  </tbody>
</table>
@endcomponent



{{ $idea->nodo->infocenter->last()->extension}}

Gracias,<br>
{{config('mail.from.name')}} <br>
Gestión {{ config('app.name') }}
@slot('subcopy')
<center>Este correo es solo informativo por favor no lo responda.</center>
<br>

@endslot

@endcomponent
