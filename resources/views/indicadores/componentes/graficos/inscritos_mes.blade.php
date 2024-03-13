<div class="row">
    @if (session()->get('login_role') == App\User::IsAuxiliar() || session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsAdministrador())
        <div class="input-field col s12 m6 l6">
            <select multiple name="txtnodo_select_inscritos_mes[]" id="txtnodo_select_inscritos_mes" style="width: 100%">
                @if (session()->get('login_role') == auth()->user()->IsAuxiliar() || session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
                    <option value="all" selected>Todos</option>
                @endif
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
            </select>
            <label for="txtnodo_select_inscritos_mes">Seleccione el nodo</label>
        </div>
    @endif
    @if (session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsInfocenter() )
        <div class="input-field col s12 m6 l6">
            <select multiple name="txtexperto_inscritos[]" id="txtexperto_inscritos" style="width: 100%">
                <option value="all" selected>Todos</option>
                @foreach($expertos as $experto)
                    <option value="{{$experto->id}}">{{$experto->documento}} - {{$experto->nombres}} {{$experto->apellidos}}</option>
                @endforeach
            </select>
            <label for="txtexperto_inscritos">Seleccione el experto</label>
        </div>
    @endif
    <div class="input-field col s12 m6 l6">
        <button type="submit" onclick="consultarProyectosInscritosMes(event, '/seguimiento/seguimientoProyectosInscritosPorMes/')" class="btn bg-secondary left show-on-large hide-on-med-and-down">
            <i class="material-icons left">file_download</i>Generar gráfico
        </button>
    </div>
</div>
<div class="row">
    <div id="graficoSeguimientoInscritosPorMes_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
        <div class="row card-panel">
            <h5 class="center">
                Para consultar el seguimiento de proyectos del inscritos, debes pulsar el botón de <b>Generar gráfico</b>
            </h5>
        </div>
    </div>
</div>
