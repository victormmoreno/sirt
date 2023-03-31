
<table>
    <thead>
    <tr>
        <th>Nodo del proyecto</th>
        <th>Código de Proyecto</th>
        <th>Nombre de Proyecto</th>
        <th>Experto a cargo</th>
        <th>Línea Tecnológica</th>
        <th>Sublínea</th>
        <th>Idea de Proyecto</th>
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

        <th>Nit de la empresa</th>
        <th>Codigo CIIU</th>
        <th>Nombre de la empresa</th>
        <th>Fecha de creación de la empresa</th>
        <th>Sector</th>
        <th>Ciudad</th>
        <th>Dirección</th>
        <th>Email de la empresa</th>
        <th>Tamaño de la empresa</th>
        <th>Tipo de empresa</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $key => $proyecto)
            @foreach ($proyecto->sedes as $key => $sede)
            <tr>
            <td>{{$proyecto->present()->proyectoNode()}}</td>
            <td>{{ $proyecto->present()->proyectoCode() }}</td>
            <td>{{ $proyecto->present()->proyectoName() }}</td>
            <td>{{$proyecto->present()->proyectoUserAsesor()}}</td>
            <td>{{ $proyecto->present()->proyectoLinea()}}</td>
            <td>{{ $proyecto->present()->proyectoSublinea() }}</td>
            <td>{{ $proyecto->idea->present()->ideaCode() }} - {{ $proyecto->idea->present()->ideaName() }}</td>
            <td>{{ $proyecto->present()->proyectoAreaConocimiento() }}</td>
            <td>{{ $proyecto->present()->proyectoOtroAreaConocimiento() }}</td>
            <td>{{ $proyecto->articulacion_proyecto->actividad->present()->startDate()}}</td>
            <td>{{ $proyecto->present()->proyectoFase() }}</td>
            <td>{{ $proyecto->present()->proyectoFechaCierre() }}</td>

            @if ($proyecto->present()->proyectoFase() == 'Finalizado' || $proyecto->present()->proyectoFase() == 'Concluido sin finalizar')
            <td>{{ $proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY') }}</td>
            @else
            <td>El proyecto no se ha cerrado</td>
            @endif

            @if ($proyecto->present()->proyectoFase() == 'Finalizado' || $proyecto->present()->proyectoFase() == 'Concluido sin finalizar')
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
            <td>{{ $sede->empresa->nit }}</td>
            <td>{{ $sede->empresa->codigo_ciiu }}</td>
            <td>{{ $sede->empresa->nombre }}</td>
            <td>{{ $sede->empresa->fecha_creacion }}</td>
            <td>{{ $sede->empresa->sector->nombre }}</td>
            <td>{{ $sede->ciudad->nombre }} - {{ $sede->ciudad->departamento->nombre }}</td>
            <td>{{ $sede->direccion }}</td>
            <td>{{ $sede->empresa->email }}</td>
            <td>{{ $sede->empresa->tamanhoempresa->nombre }}</td>
            <td>{{ $sede->empresa->tipoempresa->nombre }}</td>
            </tr>

            @endforeach
        @endforeach
    </tbody>
</table>
