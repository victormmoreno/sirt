<div class="row">
    @if (session()->get('login_role') == App\User::IsAuxiliar() || session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsAdministrador())
        <div class="input-field col s12 m6 l6">
            <select multiple name="nodo_articulaciones_inscritas_mes[]" id="nodo_articulaciones_inscritas_mes" style="width: 100%">
                @if (session()->get('login_role') == auth()->user()->IsAuxiliar() || session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                    <option value="all" selected>Todos</option>
                @endif
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
            </select>
            <label for="nodo_articulaciones_inscritas_mes">Seleccione el nodo</label>
        </div>
    @endif
    <div class="input-field col s12 m6 l6">
        <button type="submit" onclick="consultarArticulacionesInscritasMes(event, '/seguimiento/seguimientoArticulacionesInscritasPorMes/')" class="btn bg-secondary left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Generar gráfico
        </button>
    </div>
</div>
<div class="row">
    <div id="graficoSeguimientoArticulacionesInscritasPorMes_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
        <div class="row card-panel">
            <h5 class="center">
                Para consultar la información de las articulaciones inscritas, debes pulsar el botón de <b>Generar gráfico</b>
            </h5>
        </div>
    </div>
</div>
