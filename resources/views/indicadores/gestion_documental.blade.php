<ul class="collapsible">
    @can('gestion_documental', Illuminate\Database\Eloquent\Model::class)
    <li>
        <div class="collapsible-header">Descargar actas de inicio de proyecto finalizados</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.gestion_documental.descarga_actas_inicio_proyecto')
        </div>
    </li>
    @endcan
</ul>