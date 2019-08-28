<br>
<br>
<br>
<br>
<br>
<br>
<table>
  <thead>
    <tr>
      <th>Código de la Edt</th>
      <th>Nombre</th>
      <th>Tipo de Edt</th>
      <th>Área de Conocimiento</th>
      <th>Fecha de Inicio</th>
      <th>Fecha de Cierre</th>
      <th>Gestor</th>
      <th>Observaciones</th>
      <th>Empleados</th>
      <th>Instructores</th>
      <th>Aprendices</th>
      <th>Público</th>
      <th>Fotografías</th>
      <th>Listado de Asistencia</th>
      <th>Informe Final</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ $edt->codigo_edt }}</td>
      <td>{{ $edt->nombre }}</td>
      <td>{{ $edt->tipoedt }}</td>
      <td>{{ $edt->areaconocimiento }}</td>
      <td>{{ $edt->fecha_inicio }}</td>
      <td>{{ $edt->fecha_cierre }}</td>
      <td>{{ $edt->gestor }}</td>
      <td>{{ $edt->observaciones }}</td>
      <td>{{ $edt->empleados }}</td>
      <td>{{ $edt->instructores }}</td>
      <td>{{ $edt->aprendices }}</td>
      <td>{{ $edt->publico }}</td>
      <td>{{ $edt->fotografias == 1 ? 'Si' : 'No' }}</td>
      <td>{{ $edt->listado_asistencia == 1 ? 'Si' : 'No' }}</td>
      <td>{{ $edt->informe_final == 1 ? 'Si' : 'No' }}</td>
    </tr>

  </tbody>
</table>
