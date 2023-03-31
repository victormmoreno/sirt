<div class="row">
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="card stats-card {{$ideas_sin_pbt != 0 ? 'red lighten-3' : 'green lighten-3'}}" style="cursor:pointer" onclick="consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', 'null')">
                <div class="card-content">
                    <span class="stats-counter">
                        @if ($ideas_sin_pbt != 0)
                            Hay {{$ideas_sin_pbt}} ideas asignadas que aún no se han registrado como proyecto en el nodo.
                            {{-- <a  class="btn bg-info"><i class="material-icons">search</i></a> --}}
                        @else
                            El nodo está al día con la ideas asignadas por el dinamizador.
                        @endif
                    </span>
                    <br>
                </div>
                <div class="progress stats-card-progress bg-secondary">
                    <div class="determinate"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card stats-card {{$proyectos_limite_inicio != 0 ? 'orange lighten-3' : 'green lighten-3'}}" style="cursor:pointer" onclick="consultarProyectosInicio('{{request()->user()->getNodoUser()}}', 'null')">
                <div class="card-content">
                    <span class="stats-counter">
                        @if ($proyectos_limite_inicio != 0)
                            Hay {{$proyectos_limite_inicio}} proyectos atrasados en la fase de inicio en el nodo (Máximo {{config('app.proyectos.duracion.inicio')}} días en esta fase).
                            {{-- <a  class="btn bg-info"><i class="material-icons">search</i></a> --}}
                        @else
                            No hay proyectos con mas de {{config('app.proyectos.duracion.inicio')}} días en la fase de inicio en el nodo.
                        @endif
                    </span>
                    <br>
                </div>
                <div class="progress stats-card-progress bg-secondary">
                    <div class="determinate"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card stats-card {{$proyectos_limite_planeacion != 0 ? 'orange lighten-3' : 'green lighten-3'}}" style="cursor:pointer" onclick="consultarProyectosPlaneacion('{{request()->user()->getNodoUser()}}', 'null')">
                <div class="card-content">
                    <span class="stats-counter">
                        @if ($proyectos_limite_planeacion != 0)
                            Hay {{$proyectos_limite_planeacion}} proyectos atrasados en la fase de planeación en el nodo (Máximo {{config('app.proyectos.duracion.planeacion')}} días en esta fase).
                        @else
                            No hay proyectos con mas de {{config('app.proyectos.duracion.planeacion')}} días en la fase de planeación en el nodo.
                        @endif
                    </span>
                    <br>
                </div>
                <div class="progress stats-card-progress bg-secondary">
                    <div class="determinate"></div>
                </div>
            </div>
        </div>
    </div>
</div>