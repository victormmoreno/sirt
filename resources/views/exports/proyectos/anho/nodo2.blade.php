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
        <th>Código del Proyecto</th>
        <th>Nombre</th>
        <th>Gestor a Cargo</th>
        <th>Idea de Proyecto</th>
        <th>Sector</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Área de Conocimiento</th>
        <th>Estado del Proyecto</th>
        <th>Tipo de Proyecto</th>
        <th>Talentos que participan en el proyecto</th>
        <th>Fecha de Inicio de Proyecto</th>
        <th>Fecha de Cierre de Proyecto</th>
        <th>¿Pertenece a la Economía Naranja?</th>
        <th>¿Articulado con Actor CT+i?</th>
        <th>Nombre del Actor CT+i</th>
        <th>¿Dirigido al área de emprendimiento SENA?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>Formato de confidencialidad y compromiso</th>
        <th>Manuel de uso de infraestructa</th>
        <th>Estado del Arte</th>
        <th>Acta de Cierre</th>
    </tr>
    </thead>
    <tbody>
      @foreach($proyectos as $value)
        <tr>
          <td>{{ $value->codigo_proyecto }}</td>
          <td>{{ $value->nombre }}</td>
          <td>{{ $value->gestor }}</td>
          <td>{{ $value->nombre_idea }}</td>
          <td>{{ $value->nombre_sector }}</td>
          <td>{{ $value->nombre_linea }}</td>
          <td>{{ $value->sublinea_nombre }}</td>
          <td>{{ $value->nombre_areaconocimiento }}</td>
          <td>{{ $value->estado_nombre }}</td>
          <td>{{ $value->nombre_tipoarticulacion }}</td>
          <td>{{ $value->talentos }}</td>
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
