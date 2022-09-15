<div class="row">
    <div class="col s12 m4 l4">
        <ul class="collection with-header">
            <li class="collection-header center">
                <h5 class=" orange-text text-darken-3"><b>Seleccione los nodos de los que se verán los datos</b></h5>
            </li>
            <div id="">
                @include('indicadores.componentes.nodo_pagination', [
                    'idPager' => 'PagerEsperado',
                    'idTable' => 'TableEsperado',
                    'checkName' => 'txtnodo_select_list_all',
                    'listName' => 'txtnodo_select_list'
                ])
                <br>
                <center>
                    <button onclick="consultarSeguimientoEsperadoDeUnNodo('/seguimiento/seguimientoEsperadoDeUnNodo/')" class="btn">Consultar</button>
                </center>
            </div>
        </ul>
    </div>
    <div class="col s12 m1 l1">
    </div>
    <div class="col s12 m8 l8">
        <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
            <div class="row card-panel">
            <h5 class="center">
                Para consultar el seguimiento de proyectos del nodo, debes pulsar el botón de <button onclick="consultarSeguimientoEsperadoDeUnNodo('/seguimiento/seguimientoEsperadoDeUnNodo/')"
                class="btn">Consultar</button>
            </h5>
            </div>
        </div>
    </div>
</div>