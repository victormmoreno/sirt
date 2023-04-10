<div class="row">
    <div class="col s12 m4 l4">
        <div class="card stats-card {{$ideas_sin_pbt != 0 ? 'red lighten-3' : 'green lighten-3'}}" onclick="consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', '{{request()->user()->id}}')" style="cursor: pointer">
            <div class="card-content">
                <span class="stats-counter">
                    @if ($ideas_sin_pbt != 0)
                        Tienes {{$ideas_sin_pbt}} ideas asignadas que aún no has registrado como proyecto.
                    @else
                        Estás al día con las ideas asignadas por el dinamizador.
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
        <div class="card stats-card {{$proyectos_limite_inicio != 0 ? 'orange lighten-3' : 'green lighten-3'}}" onclick="consultarProyectosInicio('{{request()->user()->getNodoUser()}}', '{{request()->user()->gestor->id}}')" style="cursor: pointer">
            <div class="card-content">
                <span class="stats-counter">
                    @if ($proyectos_limite_inicio != 0)
                        Tienes {{$proyectos_limite_inicio}} proyectos atrasados en la fase de inicio (Máximo {{config('app.proyectos.duracion.inicio')}} días en esta fase).
                    @else
                        No tienes proyectos con mas de {{config('app.proyectos.duracion.inicio')}} días en la fase de inicio.
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
        <div class="card stats-card {{$proyectos_limite_planeacion != 0 ? 'orange lighten-3' : 'green lighten-3'}}" onclick="consultarProyectosPlaneacion('{{request()->user()->getNodoUser()}}', '{{request()->user()->gestor->id}}')" style="cursor: pointer">
            <div class="card-content">
                <span class="stats-counter">
                    @if ($proyectos_limite_planeacion != 0)
                        Tienes {{$proyectos_limite_planeacion}} proyectos atrasados en la fase de planeación (Máximo {{config('app.proyectos.duracion.inicio')}} días en esta fase).
                    @else
                        No tienes proyectos con mas de {{config('app.proyectos.duracion.planeacion')}} días en la fase de inicio.
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
<div class="row">
    <div class="col s12 m6 l6">
        <div class="card stats-card">
        <div class="card-content">
            <span class="stats-counter">
            <small>Aquí se visualiza la cantidad de proyectos inscritos por mes en el año actual.</small>
            </span>
            <div id="graficoSeguimientoInscritosPorMes_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="progress stats-card-progress bg-secondary">
            <div class="determinate"></div>
        </div>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="card stats-card">
        <div class="card-content">
        <div id="graficoSeguimientoPorGestorFases_column" class="green lighten-3"
            style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
            <div class="row card-panel">
            <h5 class="center">
                Para consultar el seguimiento de un experto, debes seleccionar un experto del nodo en la lista desplegable de los expertos.
            </h5>
            </div>
        </div>
        </div>
        <div class="progress stats-card-progress bg-secondary">
            <div class="determinate"></div>
        </div>
        </div>
    </div>
</div>
