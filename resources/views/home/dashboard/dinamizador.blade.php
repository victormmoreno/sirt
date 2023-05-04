<div class="row">
    <div class="col s12 m4 l4">
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
    <div class="col s12 m4 l4">
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
    <div class="col s12 m4 l4">
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
<div class="row card-panel">
    <div clas="col s12 m12 l12">
            <div class="col s12 m4 l4">
                <div class="input-field col s12 m12 l12">
                    <select id="txtgestor_id_actual" name="txtgestor_id_actual" style="width: 100%" tabindex="-1" onchange="consultarSeguimientoActualDeUnGestor(this.value)">
                    <option value="">Seleccione el experto</option>
                    @foreach($expertos as $id => $experto)
                    <option value="{{$experto->id}}">{{$experto->nombres}} {{$experto->apellidos}}</option>
                    @endforeach
                    </select>
                    <label for="txtgestor_id_actual">Experto</label>
                </div>
            </div>
            <div class="col s12 m8 l8">
                <div id="graficoSeguimientoPorGestorFases_column" class="green lighten-3"
                    style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                    <div class="row">
                    <h5 class="center">
                        Para consultar el seguimiento de un experto, debes seleccionar un experto del nodo en la lista desplegable de los expertos.
                    </h5>
                    </div>
                </div>
            </div>
    </div>
</div>
