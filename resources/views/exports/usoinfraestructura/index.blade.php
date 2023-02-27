<table>
    <thead>
        <tr>
            <th >Nodo</th>
            <th >Fecha</th>
            <th >Tipo Asesoria</th>
            <th >Nombre</th>
            <th >Fase</th>
            <th >Asesor(a)</th>
            <th >Talentos</th>
            <th >Equipos</th>
            <th >Materiales de Formación</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usos as $uso)
        <tr>
            <td>
                {{$uso->nodo}}
            </td>
            <td>
                {{$uso->fecha}}
            </td>
            <td>
                {{$uso->tipo_asesoria}}
            </td>
            <td>
                {{$uso->nombre}}
            </td>
            <td>
                {{$uso->fase}}
            </td>
            <td>
                {{$uso->asesores}}
            </td>
            <td>
                {{$uso->talentos}}
            </td>
            <td>
                {{$uso->equipos}}
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
