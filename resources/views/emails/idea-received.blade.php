@component('mail::message')
# Nueva idea Recibida - {{dd($u->nombre_nodo)}}

{{-- {{dd($user)}} --}}

Hola,
{{-- {{$user->nombre_completo}},  --}}

Cordial Saludo.

Ha recibido este mensaje porque el señor(a) <b>{{$idea->nombre_completo}}</b> ha adjuntado una nueva idea.

<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
	<thead>
		<tr>
			<th>Nombre de la idea</th>
			<th>Emprendedor</th>
			<th>Email</th>
			<th>Telefono</th>
			<th>Aprendiz Sena</th>
		</tr>

	</thead>
	<tbody>
		<tr>
			<th>{{$idea->nombreproyecto}}</th>
			<th>{{$idea->nombre_completo}}</th>
			<th>{{$idea->correo}}</th>
			<th>{{$idea->telefono}}</th>
			@if($idea->aprendizsena == 1)
				<th>Aprendiz SENA</th>
			@else
				<th>Emprendedor</th>
			@endif
		</tr>
	</tbody>


                                <!-- Body content -->
    
 </table>



@component('mail::button', ['url' => route('ideas.show',$idea->id)])
Ver idea {{$idea->nombreproyecto}}
@endcomponent



<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; border-top: 1px solid #edeff2; margin-top: 25px; padding-top: 25px;">
    <tr>
        <td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box;">
            <p style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #3d4852; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">
            	Si tiene problemas para hacer clic en el botón "Ver idea {{$idea->nombreproyecto}}", copie y pegue la siguiente URL
en su navegador web: 
<a href="{{route('ideas.show',$idea->id)}}" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; box-sizing: border-box; color: #3869d4;">{{url(config('app.url').route('ideas.show',$idea->id))}}</a></p>
        </td>
    </tr>
</table>
@endcomponent
