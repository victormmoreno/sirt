<ul class="collapsible">
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
</ul>