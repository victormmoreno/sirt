
<table>
    <thead>
    <tr>
        <th>Nodo del proyecto</th>
        <th>Código de Proyecto</th>
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
        @foreach($empresas as $value)
            <tr>
                <td>{{ $value->nodo_nombre }}</td>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->nombre_linea }}</td>
            <td>{{ $value->nombre_sublinea }}</td>
            <td>{{ $value->nombre_idea }}</td>
            <td>{{ $value->nombre_areaconocimiento }}</td>
            <td>{{ $value->otro_areaconocimiento }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->nombre_fase }}</td>
            <td>{{ $value->fecha_cierre }}</td>
            @if ($value->nombre_fase == 'Finalizado' || $value->nombre_fase == 'Suspendido')
            <td>{{ $value->anho }}</td>
            @else
            <td>El proyecto no se ha cerrado</td>
            @endif
            @if ($value->nombre_fase == 'Finalizado' || $value->nombre_fase == 'Suspendido')
            <td>{{ $value->mes }}</td>
            @else
            <td>El proyecto no se ha cerrado</td>
            @endif
            <td>{{ $value->trl_esperado }}</td>
            <td>{{ $value->trl_obtenido }}</td>
            <td>{{ $value->fabrica_productividad }}</td>
            <td>{{ $value->reci_ar_emp }}</td>
            <td>{{ $value->economia_naranja }}</td>
            <td>{{ $value->tipo_economianaranja }}</td>
            <td>{{ $value->dirigido_discapacitados }}</td>
            <td>{{ $value->tipo_discapacitados }}</td>
            <td>{{ $value->art_cti }}</td>
            <td>{{ $value->nom_act_cti }}</td>
            <td>{{ $value->diri_ar_emp }}</td>

            <td>{{ $value->nit }}</td>
            <td>{{ $value->codigo_ciiu }}</td>
            <td>{{ $value->nombre_empresa }}</td>
            <td>{{ $value->fecha_creacion }}</td>
            <td>{{ $value->nombre_sector }}</td>
            <td>{{ $value->ciudad }}</td>
            <td>{{ $value->direccion }}</td>
            <td>{{ $value->email_entidad }}</td>
            <td>{{ $value->tamanho_empresa }}</td>
            <td>{{ $value->tipo_empresa }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
