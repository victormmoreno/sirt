<table>
    <thead>
        <tr>
            <th >Nodo</th>
            <th >Linea Tecnológica</th>
            <th >Fecha</th>
            <th >Nombre de Actividad</th>
            <th >Fase</th>
            <th >Total horas Asesoria Directa</th>
            <th >Total horas Asesoria Indirecta</th>
            <th >Gestores</th>
            <th >Talentos</th>
            <th >Equipos</th>
            <th >Materiales de Formación</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usos as $uso)
        <tr>
            <td>
                {{$uso->present()->nodoUso()}}
            </td>
            <td>
                {{$uso->present()->actividadLinea()}}
            </td>
            <td>
                {{$uso->present()->fechaUsoInfraestructura()}}
            </td>
            <td>
                {{$uso->present()->actividadUsoInfraestructura()}}
            </td>
            <td>
                {{$uso->present()->faseActividad()}}
            </td>
            <td>
                {{$uso->present()->asesoriaDirecta()}}
            </td>
            <td>
                {{$uso->present()->asesoriaIndirecta()}}
            </td>
            <td>
                {{$uso->present()->usoGestores()}}
            </td>
            <td>
                {{$uso->present()->usoTalentos()}}
            </td>
            <td>
                {{$uso->present()->usoEquipos()}}
            </td>
            <td>
                {{$uso->present()->usoMateriales()}}
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
