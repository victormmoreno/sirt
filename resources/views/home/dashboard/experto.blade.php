<div class="row">
    <div class="col s12 m5 l5">
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
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="card stats-card {{$ideas_sin_pbt != 0 ? 'red lighten-3' : 'green lighten-3'}}">
                <div class="card-content">
                    <span class="stats-counter">
                        @if ($ideas_sin_pbt != 0)
                            Tienes {{$ideas_sin_pbt}} ideas asignadas que aún no has registrado como proyecto.
                            <a onclick="consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', '{{request()->user()->id}}')" class="btn bg-info"><i class="material-icons">search</i></a>
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
        <div class="row">

        </div>
    </div>
</div>