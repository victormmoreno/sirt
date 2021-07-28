<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Nodo del proyecto</th>
        <th>Nombre de Proyecto</th>
        <th>Gestor a cargo</th>
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
            @foreach ($proyecto->users_propietarios as $user)
                <tr>
                    <td>{{ $proyecto->present()->proyectoCode() }}</td>
                    <td>{{ $proyecto->present()->proyectoNode()}}</td>
                    <td>{{ $proyecto->present()->proyectoName()}}</td>
                    <td>{{ $proyecto->present()->proyectoUserAsesor() }}</td>
                    <td>{{ $proyecto->present()->proyectoLinea() }}</td>
                    <td>{{ $proyecto->present()->proyectoSublinea() }}</td>
                    <td>{{ $proyecto->idea->present()->ideaCode() }} - {{ $proyecto->idea->present()->ideaName()}}</td>
                    <td>{{ $proyecto->present()->proyectoAreaConocimiento() }}</td>
                    <td>{{ $proyecto->present()->proyectoOtroAreaConocimiento() }}</td>
                    <td>{{ $proyecto->articulacion_proyecto->actividad->present()->startDate() }}</td>
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

                    <td>{{ $user->documento }}</td>
                    <td>{{ $user->nombres }}</td>
                    <td>{{ $user->apellidos }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->celular }} / {{ $user->telefono }}</td>
                    <td>{{ $user->present()->userGenero() }}</td>
                    <td>{{ $user->grupoSanguineo->nombre }}</td>
                    <td>{{ $user->estrato }}</td>
                    <td>{{ $user->present()->userLugarResidencia() }}</td>
                    <td>{{ $user->direccion }}</td>
                    <td>{{ $user->barrio }}</td>
                    <td>{{ $user->fechanacimiento }}</td>
                    <td>{{ $user->present()->userEps() }}</td>
                    <td>{{ $user->present()->userOtraEps() }}</td>
                    <td>{{ $user->present()->userEtnia() }}</td>
                    <td>{{ $user->present()->userGradoDiscapacidad() }}</td>
                    <td>{{ $user->present()->userDescripcionGradoDiscapacidad() }}</td>
                    <td>{{ $user->present()->userGradoEscolaridad() }}</td>
                    <td>{{ $user->present()->userInstitucion() }}</td>
                    <td>{{ $user->present()->userTituloObtenido() }}</td>
                    <td>{{ $user->present()->userFechaTerminacion() }}</td>
                    <td>{{ $user->present()->userNombreTipoTalento() }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
