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
        <th>Regional</th>
        <th>Centro de Formación</th>
        <th>Nombre Nodo</th>
        <th>Dirección</th>
        <th>Ubicación</th>
        <th>Correo Electrónico</th>
        <th>Telefono Fijo</th>
        <th>Lineas Tecnológicas</th>
  
    </tr>
    </thead>
    <tbody>
      @foreach($nodos as $nodo)
        <tr>
          <td>{{ $nodo->centro->regional->nombre }}</td>
          <td>{{ $nodo->centro->entidad->nombre }}</td>
          <td>Tecnoparque Nodo {{ $nodo->entidad->nombre }}</td>
          <td>{{ $nodo->direccion }}</td>
          <td>{{ $nodo->entidad->ciudad->nombre }} ({{$nodo->entidad->ciudad->departamento->nombre}})</td>
          <td>{{ $nodo->entidad->email_entidad }}</td>
          <td>{{ $nodo->telefono }}</td>
          <td>{{ $nodo->lineas->implode('nombre', ', ') }}</td>
        </tr>
      @endforeach

    </tbody>
</table>
