<div class="row">
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="card stats-card {{$ideas_sin_pbt != 0 ? 'red lighten-3' : 'green lighten-3'}}">
                <div class="card-content">
                    <span class="stats-counter">
                        @if ($ideas_sin_pbt != 0)
                            Hay {{$ideas_sin_pbt}} ideas asignadas que aún no se han registrado como proyecto en el nodo.
                            <a onclick="consultarIdeasPendientes('{{request()->user()->getNodoUser()}}', 'null')" class="btn bg-info"><i class="material-icons">search</i></a>
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

        </div>
    </div>
</div>