<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Nodo del proyecto</th>
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

        <th>Número de Documento del Talento</th>
        <th>Nombres del Talento</th>
        <th>Apellidos del Talento</th>
        <th>Correo Electrónico</th>
        <th>Contacto</th>
        <th>Género</th>
        <th>Grupo sanguineo</th>
        <th>Estrato Social</th>
        <th>Ciudad de residencia</th>
        <th>Dirección</th>
        <th>Barrio</th>
        <th>Fecha de Nacimiento</th>
        <th>Eps</th>
        <th>Otra eps</th>
        <th>Etnia a la que pertenece</th>
        <th>¿Tiene algún grado de discapacidad?</th>
        <th>¿Cuál es el grado de discapacidad?</th>
        <th>Grado de escolaridad</th>
        <th>Institución</th>
        <th>Título obtenido</th>
        <th>Fecha de terminación</th>
        <th>Tipo de talento</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $proyecto)
            @foreach ($proyecto->articulacion_proyecto->talentos as $talento)
                <tr>
                    <td>{{ $proyecto->present()->proyectoCode()}}</td>
                    <td>{{ $proyecto->present()->proyectoNode() }}</td>
                    <td>{{ $proyecto->present()->proyectoName()}}</td>
                    <td>{{ $proyecto->present()->proyectoUserAsesor() }}</td>
                    <td>{{ $proyecto->present()->proyectoLinea() }}</td>
                    <td>{{ $proyecto->present()->proyectoSublinea() }}</td>
                    <td>{{ $proyecto->idea->present()->ideaCode() }} - {{ $proyecto->idea->present()->ideaName()}}</td>
                    <td>{{ $proyecto->present()->proyectoAreaConocimiento() }}</td>
                    <td>{{ $proyecto->present()->proyectoOtroAreaConocimiento() }}</td>
                    <td>{{ $proyecto->articulacion_proyecto->actividad->present()->startDate()}}</td>
                    <td>{{ $proyecto->present()->proyectoFase() }}</td>
                    <td>{{ $proyecto->present()->proyectoFechaCierre() }}</td>

                    @if ($proyecto->present()->proyectoFase() == 'Finalizado' || $proyecto->present()->proyectoFase() == 'Suspendido')
                    <td>{{ $proyecto->articulacion_proyecto->actividad->fecha_cierre->isoFormat('YYYY') }}</td>
                    @else
                    <td>El proyecto no se ha cerrado</td>
                    @endif

                    @if ($proyecto->present()->proyectoFase() == 'Finalizado' || $proyecto->present()->proyectoFase() == 'Suspendido')
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

                    <td>{{ $talento->user->documento }}</td>
                    <td>{{ $talento->user->nombres }}</td>
                    <td>{{ $talento->user->apellidos }}</td>
                    <td>{{ $talento->user->email }}</td>
                    <td>{{ $talento->user->celular }} / {{ $talento->user->telefono }}</td>
                    <td>{{ $talento->user->present()->userGenero() }}</td>
                    <td>{{ $talento->user->grupoSanguineo->nombre }}</td>
                    <td>{{ $talento->user->estrato }}</td>
                    <td>{{ $talento->user->present()->userLugarResidencia() }}</td>
                    <td>{{ $talento->user->direccion }}</td>
                    <td>{{ $talento->user->barrio }}</td>
                    <td>{{ $talento->user->fechanacimiento }}</td>
                    <td>{{ $talento->user->present()->userEps() }}</td>
                    <td>{{ $talento->user->present()->userOtraEps() }}</td>
                    <td>{{ $talento->user->present()->userEtnia() }}</td>
                    <td>{{ $talento->user->present()->userGradoDiscapacidad() }}</td>
                    <td>{{ $talento->user->present()->userDescripcionGradoDiscapacidad() }}</td>
                    <td>{{ $talento->user->present()->userGradoEscolaridad() }}</td>
                    <td>{{ $talento->user->present()->userInstitucion() }}</td>
                    <td>{{ $talento->user->present()->userTituloObtenido() }}</td>
                    <td>{{ $talento->user->present()->userFechaTerminacion() }}</td>
                    <td>{{ $talento->user->present()->userNombreTipoTalento() }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
