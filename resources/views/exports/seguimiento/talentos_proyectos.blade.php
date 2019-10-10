<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Número de Documento del Talento</th>
        <th>Nombres del Talento</th>
        <th>Apellidos del Talento</th>
        <th>Correo Electrónico</th>
        <th>Contacto</th>
    </tr>
    </thead>
    <tbody>
      @foreach($talentos as $value)
        <tr>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->documento }}</td>
          <td>{{ $value->nombres }}</td>
          <td>{{ $value->apellidos }}</td>
          <td>{{ $value->email }}</td>
          <td>{{ $value->contactos }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
