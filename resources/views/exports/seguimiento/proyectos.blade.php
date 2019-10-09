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
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Área de Conocimiento</th>
        <th>Estado del Proyecto</th>
        <th>Tipo de Proyecto</th>
        {{-- <th>Talentos que participan en el proyecto</th> --}}
        <th>Fecha de Inicio de Proyecto</th>
        <th>Fecha de Cierre de Proyecto</th>
        <th>Observaciones del Proyecto</th>
        <th>Impacto del Proyecto</th>
        <th>Resultados del Proyecto</th>
        <th>¿Pertenece a la Economía Naranja?</th>
        <th>¿Articulado con Actor CT+i?</th>
        <th>Nombre del Actor CT+i</th>
        <th>¿Dirigido al área de emprendimiento SENA?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>¿Dinero de Regalías?</th>
        <th>Formato de confidencialidad y compromiso</th>
        <th>Manual de uso de infraestructa</th>
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
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->nombre_proyecto }}</td>
          <td>{{ $value->nombre_idea }}</td>
          <td>{{ $value->nombre_sector }}</td>
          <td>{{ $value->nombre_linea }}</td>
          <td>{{ $value->nombre_sublinea }}</td>
          <td>{{ $value->nombre_areaconocimiento }}</td>
          <td>{{ $value->nombre_estado }}</td>
          <td>{{ $value->nombre_tipoproyecto }}</td>
          {{-- <td>{{ $value->talentos }}</td> --}}
          <td>{{ $value->fecha_inicio }}</td>
          <td>{{ $value->fecha_cierre }}</td>
          <td>{{ $value->observaciones_proyecto }}</td>
          <td>{{ $value->impacto_proyecto }}</td>
          <td>{{ $value->resultado_proyecto }}</td>
          <td>{{ $value->economia_naranja == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->art_cti == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->nom_act_cti }}</td>
          <td>{{ $value->diri_ar_emp == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->reci_ar_emp == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->dine_reg == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->acc == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->manual_uso_inf == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->acta_inicio == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->estado_arte == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->actas_seguimiento == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->video_tutorial == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->url_videotutorial }}</td>
          <td>{{ $value->ficha_caracterizacion == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->acta_cierre == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->encuesta == 1 ? 'Si' : 'No' }}</td>
          <td>{{ $value->revisado_final }}</td>
        </tr>
      @endforeach

    </tbody>
</table>
