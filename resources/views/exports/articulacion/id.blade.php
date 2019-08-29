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
        <th>Estado</th>
        <th>Fecha de Cierre</th>
        <th>Revisado Final</th>
        <th>Gestor</th>
        <th>Observaciones</th>
        <th>Acta de Inicio</th>
        <th>Formato de Confidencialida y Compromiso</th>
        <th>Actas de Seguimiento</th>
        <th>Acta de Cierre</th>
        <th>Informe Final de la Asesoria</th>
        <th>Encuenta de Satisfacción (Pantallazo)</th>
    </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $articulacion->codigo_articulacion }}</td>
        <td>{{ $articulacion->nombre }}</td>
        <td>{{ $articulacion->tipoArticulacion }}</td>
        <td>{{ $articulacion->tipo_articulacion }}</td>
        <td>{{ $articulacion->fecha_inicio->toDateString() }}</td>
        <td>{{ $articulacion->estado }}</td>
        <td>{{ $articulacion->fecha_cierre }}</td>
        <td>{{ $articulacion->revisado_final }}</td>
        <td>{{ $articulacion->nombre_completo_gestor }}</td>
        <td>{{ $articulacion->observaciones }}</td>
        <td>{{ $articulacion->acta_inicio == 1 ? 'Si' : 'No' }}</td>
        <td>{{ $articulacion->tipo_articulacion != 'Grupo de Investigación' ? $articulacion->acc == 1 ? 'Si' : 'No' : 'No Aplica' }}</td>
        <td>{{ $articulacion->actas_seguimiento == 1 ? 'Si' : 'No' }}</td>
        <td>{{ $articulacion->acta_cierre == 1 ? 'Si' : 'No' }}</td>
        <td>{{ $articulacion->tipo_articulacion != 'Grupo de Investigación' ? $articulacion->informe_final == 1 ? 'Si' : 'No' : 'No Aplica' }}</td>
        <td>{{ $articulacion->tipo_articulacion != 'Grupo de Investigación' ? $articulacion->pantallazo == 1 ? 'Si' : 'No' : 'No Aplica' }}</td>
      </tr>
    </tbody>
</table>
