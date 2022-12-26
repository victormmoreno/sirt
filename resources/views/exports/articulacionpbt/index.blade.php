<table>
    <thead>
        <tr>
            <th>
                Nodo
            </th>
            <th>
                Código Articulación
            </th>
            <th>
                Nombre Articulación
            </th>
            <th>
                Articulador
            </th>
            <th>
                Fase
            </th>
            <th>
                Fecha de Inicio
            </th>
            <th>
                PBT
            </th>
            <th>
                Idea
            </th>
            <th>
                Tipo Articulación
            </th>
            <th>
                Tipo convocatoria
            </th>
            <th>
                Alcance
            </th>
            <th>
                Entidad con la que se realiza la articulación
            </th>
            <th>
                Nombre de contacto
            </th>
            <th>
                Fecha esperada de finalización
            </th>
            <th>
                Objetivo
            </th>
            <th>
                Talentos participantes
            </th>

        </tr>
    </thead>
    <tbody>
        @forelse($articulaciones as $articulacion)
        <tr>
            <td>
                {{$articulacion->present()->articulacionPbtNodo()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtCode()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtName()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtUserAsesor()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtNameFase()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtstartDate()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtCodeProyecto()}} - {{$articulacion->present()->articulacionPbtNameProyecto()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtCodeIdeaProyecto()}} - {{$articulacion->present()->articulacionPbtNameIdeaProyecto()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtNombreTipoArticulacion()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtNameTipoVinculacion()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtNombreAlcanceArticulacion()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtEntidad()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtNombreContacto()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtFechaFinalizacion()}}
            </td>
            <td>
                {{$articulacion->present()->articulacionPbtObjetivo()}}
            </td>
            <td>
                {{$articulacion->present()->fullNameTalent()->implode(',')}}
            </td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
