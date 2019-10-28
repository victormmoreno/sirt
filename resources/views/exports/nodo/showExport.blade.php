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
          <td>{{ $gestor->user->documento }}</td>
          <td>{{ $gestor->user->nombres }} {{ $gestor->user->apellidos }}</td>
          <td>{{ $gestor->user->fechanacimiento->isoFormat('LL') }}</td>
          <td>{{ $gestor->user->email }}</td>
          <td>{{ $gestor->user->telefono }} </td>
          <td>{{ $gestor->user->celular }}</td>
          <td>{{ $gestor->user->getRoleNames()->implode(', ') }}</td>
          <td>{{ $gestor->lineatecnologica->abreviatura }} - {{ $gestor->lineatecnologica->nombre }}</td>
          <td>$ {{ number_format($gestor->honorarios) }}</td>
        </tr>
      @endforeach
    </tbody>
</table>