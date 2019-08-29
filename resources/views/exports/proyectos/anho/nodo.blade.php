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
        <th>Idea de Proyecto</th>
        <th>Sector</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Área de Conocimiento</th>
        <th>Estado del Proyecto</th>
        <th>Tipo de Articulación</th>
        <th>Talentos que participan en el proyecto</th>
        <th>Observaciones del Proyecto</th>
        <th>Impacto del Proyecto</th>
        <th>¿Pertenece a la Economía Naranja?</th>
        <th>Resultados del Proyecto</th>
        <th>Articulado Actor CT+i</th>
        <th>Nombre del Actor CT+i</th>
        <th>¿Dirigido al área de emprendimiento SENA?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>¿Dinero de Regalías?</th>
        <th>Formato de confidencialidad y compromiso</th>
        <th>Manuel de uso de infraestructa</th>
        <th>Acta de Inicio</th>
        <th>Estado del Arte</th>
        <th>Actas de Seguimiento</th>
        <th>Vídeo Tutorial</th>
        <th>Link del Video Tutorial</th>
        <th>Ficha de Caracterización</th>
        <th>Acta de Cierre</th>
        <th>Encuesta de Satisfacción (Pantallazo)</th>
        <th>Revisado Final</th>
    </tr>
    </thead>
    <tbody>
      @foreach($proyectos as $value)
        <tr>
          <td>{{ $value->codigo_edt }}</td>
          <td>{{ $value->nombre }}</td>
          <td>{{ $value->tipo_edt }}</td>
          <td>{{ $value->area_conocimiento }}</td>
          <td>{{ $value->fecha_inicio }}</td>
          <td>{{ $value->fecha_cierre }}</td>
          <td>{{ $value->gestor }}</td>
          <td>{{ $value->observaciones }}</td>
          <td>{{ $value->empleados }}</td>
          <td>{{ $value->instructores }}</td>
          <td>{{ $value->aprendices }}</td>
          <td>{{ $value->publico }}</td>
          <td>{{ $value->fotografias == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->listado_asistencia == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->informe_final == 1 ? 'Si' : 'No' }}</td>
        </tr>
      @endforeach

    </tbody>
</table>
