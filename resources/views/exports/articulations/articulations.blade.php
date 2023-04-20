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
        <th>Idea</th>
        <th>PBT</th>
        {{-- <th>Fase PBT</th>
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
        <th>Personas dueñas de la propiedad intelectual</th> --}}
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
                <td>{{ $articulation->fase }}</td>
                <td>{{ $articulation->articulation_end_date }}</td>

                @if ($articulation->fase == 'Finalizado' || $articulation->fase == 'Concluido sin finalizar')
                    <td>{{ $articulation->articulation_end_date_year }}</td>
                @else
                    <td>La articulación no se ha cerrado</td>
                @endif

                @if ($articulation->fase == 'Finalizado' || $articulation->fase == 'Concluido sin finalizar')
                    <td>{{ $articulation->articulation_end_date_month }}</td>
                @else
                    <td>La articulación no se ha cerrado</td>
                @endif
                <td>{{ $articulation->idea}}</td>
                <td>{{ $articulation->codigo_proyecto }} - {{ $articulation->nombre_proyecto }}</td>


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
