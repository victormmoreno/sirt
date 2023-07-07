<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Código de idea</th>
            <th>Nombre</th>
            <th>Estado de idea</th>
            <th>Nombre Completo</th>
            <th>Correo Electrónico</th>
            <th>Teléfono / Celular</th>
            <th>¿Viene de Convocatoria?</th>
            <th>Nombre de convocatoria</th>
            <th>¿Avalada por empresa?</th>
            <th>Empresa</th>
            <th>Fecha de registro</th>
            <th>Código del taller de fortalecimiento</th>
            <th>Fecha del taller de fortalecimiento</th>
            <th>Código del comité</th>
            <th>Fecha del comité</th>
            <th>Estado del comité</th>
            <th>¿Se aprobó en este comité?</th>
            <th>Experto asignado a la idea de proyecto</th>
            <th>Código de proyecto</th>
            <th>Mas información</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ideas as $idea)
        <tr>
            <td>
                {{isset($idea->nodo->entidad->nombre) ? "{$idea->nodo->entidad->nombre}" : 'No registra'}}
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
            @if ($idea->entrenamiento->isEmpty())
                <td>No se ha registrado en taller de fortalecimiento.</td>
                <td>No se ha registrado en taller de fortalecimiento.</td>
            @else
                <td>
                    {{$idea->entrenamiento->last()->codigo_entrenamiento}}
                </td>
                <td>
                    {{$idea->entrenamiento->last()->fecha_sesion1}}
                </td>
            @endif
            @if ($idea->comites->isEmpty())
                <td>No se ha registrado comité.</td>
                <td>No se ha registrado comité.</td>
                <td>No se ha registrado comité.</td>
                <td>No se ha registrado comité.</td>
            @else
                <td>
                    {{$idea->comites->last()->codigo}}
                </td>
                <td>
                    {{$idea->comites->last()->fechacomite}}
                </td>
                <td>
                    {{$idea->comites->last()->estado->nombre}}
                </td>
                <td>
                    {{$idea->comites->last()->pivot->admitido == 0 ? "No" : "Si"}}
                </td>
            @endif
            @if ($idea->asesor == null)
                <td>No se encontró al experto asociado</td>
            @else
                <td>{{$idea->asesor->nombres}} {{$idea->asesor->apellidos}}</td>
            @endif
            @if ($idea->proyecto == null)
                <td>No se encontró proyecto asociado</td>
            @else
                <td>{{$idea->proyecto->present()->proyectoCode()}}</td>
            @endif
            <td><a href="{{route('idea.detalle', $idea->id)}}">{{route('idea.detalle', $idea->id)}}</a></td>
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
