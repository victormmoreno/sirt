<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Código del Proyecto</th>
        <th>Nombre del Proyecto</th>
        <th>Idea de Proyecto</th>
        <th>Sector</th>
        <th>Gestor</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Área de Conocimiento</th>
        <th>Estado del Proyecto</th>
        <th>Tipo de Proyecto</th>
        <th>Fecha de Inicio de Proyecto</th>
        <th>Fecha de Cierre de Proyecto</th>
        <th>¿Pertenece a la Economía Naranja?</th>
        <th>¿Articulado con Actor CT+i?</th>
        <th>Nombre del Actor CT+i</th>
        <th>¿Dirigido al área de emprendimiento SENA?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>Formato de confidencialidad y compromiso</th>
        <th>Manual de uso de infraestructa</th>
        <th>Estado del Arte</th>
        <th>Acta de Cierre</th>
    </tr>
    </thead>
    <tbody>
      @foreach($proyectos as $value)
        <tr>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->nombre_proyecto }}</td>
          <td>{{ $value->nombre_idea }}</td>
          <td>{{ $value->nombre_sector }}</td>
          <td>{{ $value->nombre_gestor }}</td>
          <td>{{ $value->nombre_linea }}</td>
          <td>{{ $value->nombre_sublinea }}</td>
          <td>{{ $value->nombre_areaconocimiento }}</td>
          <td>{{ $value->nombre_estado }}</td>
          <td>{{ $value->nombre_tipoproyecto }}</td>
          <td>{{ $value->fecha_inicio }}</td>
          <td>{{ $value->fecha_cierre }}</td>
          <td>{{ $value->economia_naranja == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->art_cti == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->nom_act_cti }}</td>
          <td>{{ $value->diri_ar_emp == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->reci_ar_emp == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->acc == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->manual_uso_inf == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->estado_arte == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->acta_cierre == 1 ? 'Si' : 'No' }}</td>
        </tr>
      @endforeach

    </tbody>
</table>
