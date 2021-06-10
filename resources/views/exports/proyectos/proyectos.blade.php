<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Gestor a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Idea de Proyecto</th>
        <th>Código del Proyecto</th>
        <th>Nombre</th>
        <th>Área de Conocimiento</th>
        <th>Otro área de conocimiento</th>
        <th>Fecha de Inicio de Proyecto</th>
        <th>Fase actual del proyecto</th>
        <th>Fecha de Cierre de Proyecto</th>
        <th>Año de cierre</th>
        <th>Mes de cierre</th>
        <th>TRL esperado</th>
        <th>TRL obtenido</th>
        <th>¿Recibido a través de fábrica de productividad?</th>
        <th>¿Recibido a través del área de emprendimiento SENA?</th>
        <th>¿El proyecto pertenece a la economía naranja?</th>
        <th>¿Qué tipo de proyecto de economía naranja?</th>
        <th>¿El proyecto está dirigido a discapacitados?</th>
        <th>¿A que tipo de personas en condición de discapacidad?</th>
        <th>¿Articulado con CT+i?</th>
        <th>¿Nombre del actor CT+i?</th>
        <th>¿Dirigido a área de emprendimiento SENA?</th>
        <th>Empresas dueñas de la propiedad intelectual</th>
        <th>Grupos de investigación dueños de la propiedad intelectual</th>
        <th>Personas dueñas de la propiedad intelectual</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $proyecto)
        <tr>
          <td>{{ $proyecto->articulacion_proyecto->actividad->nodo->entidad->nombre }}</td>
          <td>{{ $proyecto->articulacion_proyecto->actividad->gestor->user->present()->userFullName() }}</td>
          <td>{{ $proyecto->sublinea->linea->nombre }}</td>
          <td>{{ $proyecto->sublinea->nombre }}</td>
          <td>{{ $proyecto->idea->codigo_idea }} - {{ $proyecto->idea->nombre_proyecto }}</td>
          <td>{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</td>
          <td>{{ $proyecto->articulacion_proyecto->actividad->nombre }}</td>
          <td>{{ $proyecto->areaconocimiento->nombre }}</td>
          <td>{{ $proyecto->present()->proyectoOtroAreaConocimiento() }}</td>
          <td>{{ $proyecto->articulacion_proyecto->actividad->fecha_inicio->isoFormat('YYYY-MM-DD') }}</td>
          <td>{{ $proyecto->fase->nombre }}</td>
          <td>{{ $proyecto->present()->proyectoFechaCierre() }}</td>

          @if ($proyecto->fase->nombre == 'Finalizado' || $proyecto->fase->nombre == 'Suspendido')
            <td>{{ $proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY') }}</td>
          @else
            <td>El proyecto no se ha cerrado</td>
          @endif
          
          @if ($proyecto->fase->nombre == 'Finalizado' || $proyecto->fase->nombre == 'Suspendido')
            <td>{{ $proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('MM') }}</td>
          @else
            <td>El proyecto no se ha cerrado</td>
          @endif

          <td>{{ $proyecto->present()->proyectoTrlEsperado() }}</td>
          <td>{{ $proyecto->present()->proyectoTrlObtenido() }}</td>
          <td>{{ $proyecto->present()->proyectoFabricaProductividad() }}</td>
          <td>{{ $proyecto->present()->proyectoRecibidoAreaEmprendimiento() }}</td>
          <td>{{ $proyecto->present()->proyectoEconomiaNaranja() }}</td>
          <td>{{ $proyecto->present()->proyectoTipoEconomiaNaranja() }}</td>
          <td>{{ $proyecto->present()->proyectoDirigidoDiscapacitados() }}</td>
          <td>{{ $proyecto->present()->proyectoDirigidoTipoDiscapacitados() }}</td>
          <td>{{ $proyecto->present()->proyectoActorCTi() }}</td>
          <td>{{ $proyecto->present()->proyectoNombreActorCTi() }}</td>
          <td>{{ $proyecto->present()->proyectoDirigidoAreaEmprendimiento() }}</td>
          <td>
            @foreach ($proyecto->sedes as $sede)
            {{ $sede->empresa->nit }} - {{ $sede->empresa->nombre }};
            @endforeach
          </td>
          <td>
            @foreach ($proyecto->gruposinvestigacion as $grupo)
            {{ $grupo->codigo_grupo }} - {{ $grupo->entidad->nombre }};
            @endforeach
          </td>
          <td>
            @foreach ($proyecto->users_propietarios as $user)
            {{ $user->present()->userFullName() }};
            @endforeach
          </td>
        </tr>
        @endforeach
    </tbody>
</table>
