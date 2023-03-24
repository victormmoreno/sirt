<ul class="collapsible">
    <li>
        <div class="collapsible-header"><i class="material-icons">edit</i>Generar indicadores de proyectos inscritos entre un rango de fechas</div>
        <div class="collapsible-body">
        @include('indicadores.componentes.proyectos.inscritos')
        </div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">done</i>Generar indicadores de proyectos finalizados y suspendidos entre un rango de fechas</div>
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
        <div class="collapsible-header"><i class="material-icons">done_all</i>Generar todos</div>
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
    <li>
        <div class="collapsible-header"><i class="material-icons">assignment</i>Metas de tecnoparque ({{__('Articulations')}})</div>
        <div class="collapsible-body">
        @include('indicadores.componentes.metas.metas-articulaciones')
        </div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">lightbulb</i>Ideas de tecnoparque</div>
        <div class="collapsible-body">
        @include('indicadores.componentes.ideas.download')
        </div>
    </li>
    <li>
        <div class="collapsible-header"><i class="material-icons">transit_enterexit</i>Ingreso de visitantes</div>
        <div class="collapsible-body">
        @include('indicadores.componentes.ingresos.download')
        </div>
    </li>
</ul>
