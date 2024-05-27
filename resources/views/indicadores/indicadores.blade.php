<ul class="collapsible">
    @can('showIndicadoresProyectos', Illuminate\Database\Eloquent\Model::class)
        <li>
            <div class="collapsible-header"><i class="material-icons">edit</i>Generar indicadores de proyectos inscritos entre un rango de fechas</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.proyectos.inscritos')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Generar indicadores de proyectos finalizados y cancelados entre un rango de fechas</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.proyectos.finalizados')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">play_arrow</i>Generar indicadores de proyectos activos</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.proyectos.activos')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">done_all</i>Generar todos los indicadores de proyectos</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.proyectos.todos')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>Metas de tecnoparque (Proyectos)</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.metas.metas-proyectos')
            </div>
        </li>
    @endcan
    @can('showIndicadoresArticulacions', Illuminate\Database\Eloquent\Model::class)
        <li>
            <div class="collapsible-header"><i class="material-icons">edit</i>Generar indicadores de articulaciones inscritas entre un rango de fechas</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.articulaciones.inscritas')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Generar indicadores de articulaciones finalizadas y canceladas entre un rango de fechas</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.articulaciones.finalizadas')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">play_arrow</i>Generar indicadores de articulaciones activas</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.articulaciones.activas')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">done_all</i>Generar todos los indicadores de articulaciones</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.articulaciones.todos')
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>Metas de tecnoparque ({{__('Articulations')}})</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.metas.metas-articulaciones')
            </div>
        </li>
    @endcan
    <li>
        <div class="collapsible-header"><i class="material-icons">lightbulb</i>Ideas de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.ideas.download')
        </div>
    </li>
    @can('export', App\Models\IngresoVisitante::class)
        <li>
            <div class="collapsible-header"><i class="material-icons">transit_enterexit</i>Ingreso de visitantes</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.ingresos.download')
            </div>
        </li>
    @endcan
    @can('download_results', App\Models\ResultadoEncuesta::class)
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment_turned_in</i>Resultados de encuesta</div>
            <div class="collapsible-body">
                @include('indicadores.componentes.encuestas.resultados')
            </div>
        </li>
    @endcan
</ul>
