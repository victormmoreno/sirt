<form id="frmConsultarCostosAsesoria" action="{{route('asesorias.get_costos')}}" method="POST">
    @method('post')
    {!! csrf_field() !!}
    <div class="row">
        <div class="row" id="info-card">
            <div class="card grey lighten-1">
                <div class="card-content black-text">
                    <i class="material-icons left">info_outline</i>
                    <span id="info-message">Esta consulta se realiza sobre el rango fecha en el que se registran asesorias</span>
                </div>
            </div>
        </div>
        <div class="row">
            @if ( $nodos != null )
            <select name="slct_nodo" id="slct_nodo" onchange="selectDependienteDeFuncionarios(event)">
                @forelse ($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @empty
                    <option value="-1">No se encontraron expertos en el nodo</option>
                @endforelse
            </select>
            @endif
            <div class="input-field col s12 m6 l6 black-text">
                <input type="text" id="txtasesorias_desde" name="txtasesorias_desde" class="datepicker picker__input black-text" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                <label for="txtasesorias_desde" class="black-text">Desde</label>
            </div>
            <div class="input-field col s12 m6 l6 black-text">
                <input type="text" id="txtasesorias_hasta" name="txtasesorias_hasta" class="datepicker picker__input black-text" value="{{Carbon\Carbon::now()->toDateString()}}">
                <label for="txtasesorias_hasta" class="black-text">Hasta</label>
            </div>
        </div>
        <div id="por_funcionario" class="input-field">
            <select name="slct_funcionario" id="slct_funcionario">
                <optgroup label="Experto/s">
                    @forelse ($expertos as $experto)
                        <option value="{{$experto->id}}">{{$experto->nombre_completo}}</option>
                    @empty
                        <option value="-1">No se encontraron expertos</option>
                    @endforelse
                </optgroup>
                <optgroup label="Apoyo/s Técnico/s">
                    @forelse ($apoyos as $apoyo)
                        <option value="{{$apoyo->id}}">{{$apoyo->nombre_completo}}</option>
                    @empty
                        <option value="-1">No se encontraron apoyos técnico</option>
                    @endforelse
                </optgroup>
                <optgroup label="Articulador/es">
                    @forelse ($articuladores as $articulador)
                        <option value="{{$articulador->id}}">{{$articulador->nombre_completo}}</option>
                    @empty
                        <option value="-1">No se encontraron articuladores</option>
                    @endforelse
                </optgroup>
            </select>
        </div>
        <div id="por_fecha_asesoria">
        </div>
        <div id="por_proyecto_finalizado">
        </div>
    </div>
    <div class="row center">
        <input type="hidden" name="consultar_por" id="consultar_por" value="">
        <button type="submit" class="btn">Consultar</button>
    </div>
</form>