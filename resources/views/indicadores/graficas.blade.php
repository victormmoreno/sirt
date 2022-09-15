<ul class="collapsible">
    <li>
        <div class="collapsible-header">Proyectos activos (TRL esperado) de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.trl_esperado', [
                'idPager' => 'PagerEsperado',
                'idTable' => 'TableEsperado',
                'checkName' => 'txtnodo_select_list_all',
                'listName' => 'txtnodo_select_list'
            ])
        </div>
    </li>
    <li>
        <div class="collapsible-header">Fase actual de proyectos de tecnoparque</div>
        <div class="collapsible-body">
            @include('indicadores.componentes.graficos.fase_actual')
        </div>
    </li>
    {{-- <li>
        <div class="collapsible-header">Proyectos activos (TRL esperado) por nodo</div>
        <div class="collapsible-body">
        <div class="row">
            <div class="col s12 m4 l4">
            <div class="input-field col s12 m12 l12">
                <select id="txtnodo_id" name="txtnodo_id" style="width: 100%" tabindex="-1">
                <option value="">Seleccione el nodo</option>
                @foreach($nodos as $nodo)
                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_id">Nodo</label>
            </div>
            <div class="col s12 m12 l12 center">
                <button onclick="consultarSeguimientoDeUnNodo_Admin()" class="btn">Consultar</button>
            </div>
            </div>
            <div class="col s12 m8 l8">
            <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3"
                style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                <div class="row card-panel">
                <h5 class="center">
                    Para consultar el seguimiento de un nodo, debes seleccionar un nodo en la lista desplegable de los nodos y luego presionar el botón de "Consultar".
                </div>
            </div>
            </div>
        </div>
        </div>
    </li>
    <li>
        <div class="collapsible-header">Fase actual de proyectos por nodo</div>
        <div class="collapsible-body">
        <div class="row">
            <div class="col s12 m4 l4">
            <div class="input-field col s12 m12 l12">
                <select id="txtnodo_id_actual" name="txtnodo_id_actual" style="width: 100%" tabindex="-1">
                <option value="">Seleccione el nodo</option>
                @foreach($nodos as $nodo)
                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_id_actual">Nodo</label>
            </div>
            <div class="col s12 m12 l12 center">
                <button onclick="consultarSeguimientoActualDeUnNodo_Admin()" class="btn">Consultar</button>
            </div>
            </div>
            <div class="col s12 m8 l8">
            <div id="graficoSeguimientoDeUnNodoFases_column" class="green lighten-3"
                style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                <div class="row card-panel">
                <h5 class="center">
                    Para consultar el seguimiento de un nodo, debes seleccionar un nodo en la lista desplegable de los nodos y luego presionar el botón de "Consultar".
                </h5>
                </div>
            </div>
            </div>
        </div>
        </div>
    </li> --}}
</ul>