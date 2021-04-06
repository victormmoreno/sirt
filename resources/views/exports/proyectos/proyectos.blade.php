<<<<<<< HEAD
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
=======
>>>>>>> 9f9c469343babf747a28ec38dfe8e8a9bc6e6ca6
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
        <th>Tipos de propietarios</th>
    </tr>
    </thead>
    <tbody>
        @foreach($proyectos as $value)
        <tr>
<<<<<<< HEAD
          <td>{{ $value->nodo }}</td>
          <td>{{ $value->gestor }}</td>
          <td>{{ $value->nombre_linea }}</td>
          <td>{{ $value->nombre_sublinea }}</td>
          <td>{{ $value->nombre_idea }}</td>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->nombre }}</td>
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
          @php
              $datos = explode(",", $value->propietarios)
          @endphp
          <td>
            @for ($i = 0; $i < count($datos); $i++)
                @if ($datos[$i] == "App\User")
                  Persona, 
                @elseif($datos[$i] == "App\Models\Empresa")
                  Empresa, 
                @elseif($datos[$i] == "App\Models\GrupoInvestigacion")
                  Grupo de Investigación, 
                @else
                  No se encontraron datos.
                @endif
              @endfor
          </td>
=======
            <td>{{ $value->nodo }}</td>
            <td>{{ $value->gestor }}</td>
            <td>{{ $value->nombre_linea }}</td>
            <td>{{ $value->nombre_sublinea }}</td>
            <td>{{ $value->nombre_idea }}</td>
            <td>{{ $value->codigo_actividad }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->nombre_areaconocimiento }}</td>
            <td>{{ $value->otro_areaconocimiento }}</td>
            <td>{{ $value->fecha_inicio }}</td>
            <td>{{ $value->nombre_fase }}</td>
            <td>{{ $value->fecha_cierre }}</td>
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
            @php
                $datos = explode(",", $value->propietarios)
            @endphp
            <td>
                @for ($i = 0; $i < count($datos); $i++)
                    @if ($datos[$i] == "App\User")
                    Persona,
                    @elseif($datos[$i] == "App\Models\Empresa")
                    Empresa,
                    @elseif($datos[$i] == "App\Models\GrupoInvestigacion")
                    Grupo de Investigación,
                    @else
                    No se encontraron datos.
                    @endif
                @endfor
            </td>
>>>>>>> 9f9c469343babf747a28ec38dfe8e8a9bc6e6ca6
        </tr>
        @endforeach
    </tbody>
</table>
