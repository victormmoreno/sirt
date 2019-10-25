@extends('pdf.illustrated-layout')
@section('title-file', 'Nodo '. config('app.name'))
@section('content-pdf')
<table class="striped centered">
    <thead>
    	<tr>
    		<th rowspan="2" scope="col">Nodo</th>
	      <th colspan="2" scope="col">dasds</th>
	      <th colspan="6" scope="col">Expansión de ventas</th>
	    </tr>
	    <tr>
	      
	      <th colspan="8" scope="col">Expansión de ventas</th>
	    </tr>
        <tr>
            <th>
                Tipo Documento
            </th>
            <th>
                Documento
            </th>
            <th>
                Lugar Expedición Documento
            </th>
            <th>
                Nombre Completo
            </th>
            <th>
                Fecha de Nacimiento
            </th>
            <th>
                Edad
            </th>
            <th>
                Correo Electrónico
            </th>
            <th>
                Telefono
            </th>
            <th>
                Celular
            </th>
            
            
        </tr>
    </thead>
    <tbody>
	@forelse($nodo->gestores as $gestor)

        <tr>
            <td>
                {{$gestor->user->tipodocumento->nombre}}
            </td>
            <td>
                {{$gestor->user->documento}}
            </td>
            {{-- <td>
                {{$gestor->user->ciudadexpedicion->nombre}} ({{$gestor->user->useciudadexpedicion->departamento->nombre}})
            </td> --}}
            <td>
                {{$gestor->user->nombres}} {{$gestor->user->apellidos}}
            </td>
            <td>
                {{$gestor->user->fechanacimiento->isoFormat('LL')}}
            </td>
            <td>
                {{$gestor->user->fechanacimiento->age}} años
            </td>
            <td>
                {{$gestor->user->email}}
            </td>
            <td>
                {{!empty($gestor->user->telefono) ? $gestor->user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($gestor->user->celular) ? $gestor->user->celular : 'No registra'}}
            </td>
            <td>
                {{!empty($gestor->user->direccion) ? $gestor->user->direccion : 'No registra'}}
            </td>
            {{-- <td>
                {{$gestor->user->ciudad->nombre}} ({{$gestor->user->ciudad->departamento->nombre}})
            </td> --}}        
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
