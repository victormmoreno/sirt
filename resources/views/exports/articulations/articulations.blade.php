<table>
    <thead>
    <tr>
        <th>Nodo</th>
        <th>Funcionario que registro</th>
        <th>Código {{ __('Articulation') }}</th>
        <th>Nombre {{ __('Articulation') }}</th>
        <th>Fecha inicio {{ __('Articulation') }}</th>
        <th>Año Inicio {{ __('Articulation') }}</th>
        <th>Mes Inicio {{ __('Articulation') }}</th>
        <th>Fase actual de la {{ __('Articulation') }}</th>
        <th>Fecha de Cierre de la {{ __('Articulation') }}</th>
        <th>Año de cierre de {{ __('Articulation') }}</th>
        <th>Mes de cierre de {{ __('Articulation') }}</th>
        <th>Fecha esperada de finalización</th>
        <th>Tipo articulación</th>
        <th>Tipo subarticulación</th>
        <th>Alcance</th>
        <th>PBT</th>
        <th>Fase PBT</th>
        <th>Entidad con la que se realiza la articulación</th>
        <th>Nombre contacto</th>
        <th>Correo institucional de la entidad</th>
        <th>Nombre de evento o actividad (si aplica)</th>
        <th>Objetivo</th>
        <th>Se realizo la postulación al convenio, convocatoria y/o instrumento</th>
        <th>¿Aprobado? (solo si se realizó la postulación)</th>
        <th>¿Qué recibirá? (solo si se realizó la postulación y fue aprobado)</th>
        <th>¿Cúando? (solo si se realizó la postulación y fue aprobado)</th>
        <th>Informe (solo si se realizó la postulación y no fue aprobado)</th>
        <th>Justificacion (solo cuando no se realizó la postulación)</th>
        <th>Lecciones aprendidas</th>
        <th>Talento interlocutor</th>
        <th>Talentos participantes</th>
    </tr>
    </thead>
    <tbody>
        @foreach($articulations as $articulation)
            <tr>
                <td>{{ $articulation->nodo  }}</td>
                <td>{{ $articulation->created_by}}</td>
                <td>{{ $articulation->articulation_code }}</td>
                <td>{{ $articulation->articulation_name }}</td>
                <td>{{ $articulation->articulation_start_date }}</td>
                <td>{{ $articulation->articulation_start_date_year }}</td>
                <td>{{ $articulation->articulation_start_date_month }}</td>
                <td>{{ $articulation->articulation_phase }}</td>
                @if ($articulation->articulation_phase == 'Finalizado' || $articulation->articulation_phase == 'Concluido sin finalizar' || $articulation->articulation_phase == 'Suspendido')
                    <td>{{ $articulation->articulation_end_date }}</td>
                @else
                    <td>La articulación no se ha cerrado</td>
                @endif
                @if ($articulation->articulation_phase == 'Finalizado' || $articulation->articulation_phase == 'Concluido sin finalizar' || $articulation->articulation_phase == 'Suspendido')
                    <td>{{ $articulation->articulation_end_date_year }}</td>
                @else
                    <td>La articulación no se ha cerrado</td>
                @endif

                @if ($articulation->articulation_phase == 'Finalizado' || $articulation->articulation_phase == 'Concluido sin finalizar' || $articulation->articulation_phase == 'Suspendido')
                    <td>{{ $articulation->articulation_end_date_month }}</td>
                @else
                    <td>La articulación no se ha cerrado</td>
                @endif

                <td>{{ $articulation->articulation_expected_end_date }}</td>
                <td>{{ $articulation->articulation_type }}</td>
                <td>{{ $articulation->articulation_subtype }}</td>
                <td>{{ $articulation->articulation_scope }}</td>
                <td>{{ $articulation->codigo_proyecto }} - {{ $articulation->nombre_proyecto }}</td>
                <td>{{ $articulation->fase_proyecto }}</td>
                <td>{{ $articulation->articulation_entity }}</td>
                <td>{{ $articulation->articulation_contact_name }}</td>
                <td>{{ $articulation->articulation_email_entity }}</td>
                <td>{{ $articulation->articulation_summon_name }}</td>
                <td>{{ $articulation->articulation_objective }}</td>
                <td>{{ $articulation->articulation_postulation }}</td>
                <td>{{ $articulation->articulation_approval }}</td>
                <td>{{ $articulation->articulation_receive }}</td>
                <td>{{ $articulation->articulation_received_date }}</td>
                <td>{{ $articulation->articulation_report }}</td>
                <td>{{ $articulation->articulation_justification }}</td>
                <td>{{ $articulation->articulation_learned_lessons }}</td>
                <td>{{ $articulation->talent_interlocutor }}</td>
                <td>{{ $articulation->participants }}</td>


                {{-- <td>{{ $articulation->present()->proyectoTrlEsperado() }}</td>
                <td>{{ $articulation->present()->proyectoTrlObtenido() }}</td>
                <td>{{ $articulation->present()->proyectoFabricaProductividad() }}</td>
                <td>{{ $articulation->present()->proyectoRecibidoAreaEmprendimiento() }}</td>
                <td>{{ $articulation->present()->proyectoEconomiaNaranja() }}</td>
                <td>{{ $articulation->present()->proyectoTipoEconomiaNaranja() }}</td>
                <td>{{ $articulation->present()->proyectoDirigidoDiscapacitados() }}</td>
                <td>{{ $articulation->present()->proyectoDirigidoTipoDiscapacitados() }}</td>
                <td>{{ $articulation->present()->proyectoActorCTi() }}</td>
                <td>{{ $articulation->present()->proyectoNombreActorCTi() }}</td>
                <td>{{ $articulation->present()->proyectoDirigidoAreaEmprendimiento() }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
