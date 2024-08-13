<ul class="collapsible">
    @can('gestion_documental', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Descargar actas de inicio de proyecto finalizados</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.gestion_documental.descarga_actas_inicio_proyecto')
        </div>
    </li>
    @endcan
    @can('gestion_documental', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Descargar actas de cierre de proyecto finalizados</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.gestion_documental.descarga_actas_cierre_proyecto')
        </div>
    </li>
    @endcan
    @can('gestion_documental', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Descargar acuerdos de confidencialidad y compromiso de proyectos finalizados</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.gestion_documental.descarga_acuerdos_proyecto')
        </div>
    </li>
    @endcan
</ul>