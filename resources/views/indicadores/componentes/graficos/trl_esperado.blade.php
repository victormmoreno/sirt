<div class="row">
    <div class="input-field col s12 m6 l6">
        <select multiple name="txtnodo_select_list[]" id="txtnodo_select_list" style="width: 100%">
            @if (session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                <option value="all" selected>Todos</option>
            @endif
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
        </select>
        <label for="txtnodo_select_list">Seleccione el nodo</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <button type="submit" onclick="consultarSeguimientoEsperado(event, '/seguimiento/seguimientoEsperado/')" class="btn bg-secondary left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Generar gráfico
        </button>
    </div>
</div>
<div class="row">
    <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
        <div class="row card-panel">
        <h5 class="center">
            Para consultar el seguimiento de proyectos del nodo, debes pulsar el botón de "Generar gráfico"
        </h5>
        </div>
    </div>
</div>
