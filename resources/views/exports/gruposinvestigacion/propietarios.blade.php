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
        <th>Código de Proyecto</th>
        <th>Código del Grupo de Investigación</th>
        <th>Nombre del Grupo de Investigación</th>
        <th>Tipo de Grupo de Investigación</th>
        <th>Institucion que lo avala</th>
        <th>Clasificación de Colciencias</th>
        <th>Email del Grupo de Investigación</th>
        <th>Ciudad</th>
    </tr>
    </thead>
    <tbody>
      @foreach($grupos as $value)
        <tr>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->codigo_grupo }}</td>
          <td>{{ $value->nombre_grupo }}</td>
          <td>{{ $value->tipogrupo }}</td>
          <td>{{ $value->institucion }}</td>
          <td>{{ $value->nombre_clasificacion }}</td>
          <td>{{ $value->email_entidad }}</td>
          <td>{{ $value->ciudad }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
