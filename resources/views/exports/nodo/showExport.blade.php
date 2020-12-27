<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Documento de Identidad</th>
        <th>Nombres y Apellidos</th>
        <th>Fecha Nacimiento</th>
        <th>Correo Electrónico</th>
        <th>Teléfono</th>
        <th>Celular</th>
        <th>Cargo</th>
        <th>Linea Tecnonologica </th>
        <th>Honorario Mensual</th>

    </tr>
    </thead>
    <tbody>
      @foreach($nodos->gestores as $gestor)
        <tr>
            <td>
                {{isset($user->documento) ? $user->documento : 'No registra'}}
            </td>
            <td>
                {{$user->ciudadexpedicion->nombre}} ({{$user->ciudadexpedicion->departamento->nombre}})
            </td>
            <td>
                {{$user->nombres}} {{$user->apellidos}}
            </td>
            <td>
                {{isset($user->fechanacimiento) ? $user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{isset($user->email)? $user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($user->telefono) ? $user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($user->celular) ? $user->celular : 'No registra'}}
            </td>
          <td>{{ $gestor->user->getRoleNames()->implode(', ') }}</td>
          <td>{{ $gestor->lineatecnologica->abreviatura }} - {{ $gestor->lineatecnologica->nombre }}</td>
          <td>$ {{isset($user->gestor->honorarios) ? number_format($user->gestor->honorarios) : 0}}</td>
        </tr>
      @endforeach
    </tbody>
</table>
