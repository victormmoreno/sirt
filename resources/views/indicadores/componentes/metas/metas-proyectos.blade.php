<div class="row card card-panel">
    <h6 class="font-bold">Recordar que se están mostrando las metas del año actual.</h6>
    <ul class="tabs">
        <li class="tab col s6 m6 l6"><a class="active" href="#ver_metas">Visualizar metas</a></li>
        <li class="tab col s6 m6 l6"><a href="#descargar_metas">Descargar metas</a></li>
    </ul>
    <div id="ver_metas">
        @include('indicadores.componentes.metas.show_metas')
    </div>
    <div id="descargar_metas">
        @include('indicadores.componentes.metas.download_metas')
    </div>
</div>
