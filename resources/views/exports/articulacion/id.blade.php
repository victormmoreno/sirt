<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Código de la Articulación</th>
        <th>Nombre</th>
        <th>Tipo de Articulación</th>
        <th>Articulación con: </th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Cierre</th>
        <th>Gestor</th>
        <th>Formato de Confidencialida y Compromiso</th>
        <th>Acta de Cierre</th>
        <th>Informe Final de la Asesoria</th>
    </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $articulacion->codigo_articulacion }}</td>
        <td>{{ $articulacion->nombre }}</td>
        <td>{{ $articulacion->tipoArticulacion }}</td>
        <td>{{ $articulacion->tipo_articulacion }}</td>
        <td>{{ $articulacion->fecha_inicio->toDateString() }}</td>
        <td>{{ $articulacion->fecha_cierre }}</td>
        <td>{{ $articulacion->nombre_completo_gestor }}</td>
        <td>{{ $articulacion->tipo_articulacion != 'Grupo de Investigación' ? $articulacion->acc == 1 ? 'Si' : 'No' : 'No Aplica' }}</td>
        <td>{{ $articulacion->acta_cierre == 1 ? 'Si' : 'No' }}</td>
        <td>{{ $articulacion->tipo_articulacion != 'Grupo de Investigación' ? $articulacion->informe_final == 1 ? 'Si' : 'No' : 'No Aplica' }}</td>
      </tr>
    </tbody>
</table>
