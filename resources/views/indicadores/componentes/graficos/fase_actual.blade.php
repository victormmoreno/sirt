<div class="row">
    <div class="input-field col s12 m6 l6">
        <select multiple name="txtnodo_select_actual[]" id="txtnodo_select_actual" style="width: 100%">
            @if (session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                <option value="all" selected>Todos</option>
            @endif
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
        </select>
        <label for="txtnodo_select_actual">Seleccione el nodo</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <button type="submit" onclick="consultarSeguimientoDeUnNodoFases(event, '/seguimiento/seguimientoDeUnNodoFases/')" class="btn bg-secondary left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Generar gráfico
        </button>
    </div>
</div>
<div class="row">
    <div id="graficoSeguimientoDeUnNodoFases_column" class="green lighten-3"
        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
        <div class="row card-panel">
        <h5 class="center">
            Para consultar el seguimiento de un nodo, debes seleccionar un nodo en la lista desplegable de los nodos y luego presionar el botón de "Consultar".
        </h5>
        </div>
    </div>
</div>