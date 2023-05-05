<table>
    <thead>
        <tr>
            <th>
                Nodo
            </th>
            <th>
                Código de idea
            </th>
            <th>
                Nombre
            </th>
            <th>
                Estado de idea
            </th>
            <th>
                Nombre Completo
            </th>
            <th>
                Correo Electrónico
            </th>
            <th>
                Teléfono / Celular
            </th>
            <th>
                ¿Es aprendiz SENA?
            </th>
            <th>
                ¿En qué estado se encuentra su propuesta?
            </th>
            <th>
                ¿Cómo está conformado su equipo de trabajo?
            </th>
            <th>
                ¿Categoria de clasificación de propuesta?
            </th>
            <th>
                Descripción de la idea
            </th>
            <th>
                Objetivo
            </th>
            <th>
                Alcance
            </th>
            <th>
                ¿Viene de Convocatoria?
            </th>
            <th>
                Nombre de convocatoria
            </th>
            <th>
                ¿Avalada por empresa?
            </th>
            <th>
                Empresa
            </th>
            <th>
                Fecha de registro
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($ideas as $idea)
        <tr>
            <td>
                {{isset($idea->nodo->entidad->nombre) ? "Tecnoparque {$idea->nodo->entidad->nombre}" : 'No registra'}}
            </td>
            <td>
                {{isset($idea->codigo_idea) ? $idea->codigo_idea : 'No registra'}}
            </td>
            <td>
                {{isset($idea->nombre_proyecto) ? $idea->nombre_proyecto : 'No registra'}}
            </td>
            <td>
                {{isset($idea->estadoIdea) ? $idea->estadoIdea->nombre : 'No registra'}}
            </td>
            <td>
                @if (isset($idea->user->nombres))
                    {{$idea->user->nombres}} {{$idea->user->apellidos}}
                @else
                    No hay información disponible
                @endif
            </td>
            <td>
                @if (isset($idea->user->email))
                    {{$idea->user->email}}
                @else
                    No hay información disponible
                @endif
            </td>
            <td>
                @if (isset($idea->user->celular))
                    {{$idea->user->celular}}
                @else
                    No hay información disponible
                @endif
            </td>
            <td>
                {{$idea->aprendiz_sena == 1 ? 'Si': 'No'}}
            </td>
            <td>
                {{App\Models\Idea::preguntaUno($idea->pregunta1)}}
            </td>
            <td>
                {{App\Models\Idea::preguntaDos($idea->pregunta2)}}
            </td>
            <td>
                {{App\Models\Idea::preguntaTres($idea->pregunta3)}}
            </td>
            <td>
                {{isset($idea->descripcion)? $idea->descripcion: 'No registra'}}
            </td>
            <td>
                {{isset($idea->objetivo)? $idea->objetivo: 'No registra'}}
            </td>
            <td>
                {{isset($idea->alcance)? $idea->alcance: 'No registra'}}
            </td>
            <td>
                {{$idea->viene_convocatoria == 1 ? 'Si': 'No'}}
            </td>
            <td>
                {{$idea->viene_convocatoria == 1 ? $idea->convocatoria: 'No Aplica'}}
            </td>
            <td>
                {{$idea->aval_empresa == 1 ? 'Si': 'No'}}
            </td>
            <td>
                {{$idea->aval_empresa == 1 ? $idea->empresa: 'No Aplica'}}
            </td>
            <td>
                {{isset($idea->created_at) ? $idea->created_at->isoFormat('DD/MM/YYYY'): 'No registra'}}
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
