<ul class="collapsible">
    @can('showIndicadoresProyectos', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Proyectos activos (TRL esperado) de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.trl_esperado')
        </div>
    </li>
    <li>
        <div class="collapsible-header">Fase actual de proyectos de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.fase_actual')
        </div>
    </li>
    <li>
        <div class="collapsible-header">Proyectos inscritos por mes</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.inscritos_mes')
        </div>
    </li>
    <li>
        <div class="collapsible-header">Proyectos cerrados por mes</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.cerrados_mes')
        </div>
    </li>
    @endcan
    @can('showIndicadoresArticulacions', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Fase actual de Articulaciones de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.fase_actual_articulaciones')
        </div>
    </li>
    <li>
        <div class="collapsible-header">Articulaciones inscritas por mes</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.articulaciones_inscritas_mes')
        </div>
    </li>
    <li>
        <div class="collapsible-header">Articulaciones cerradas por mes</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.articulaciones_cerradas_mes')
        </div>
    </li>
    @endcan
</ul>
