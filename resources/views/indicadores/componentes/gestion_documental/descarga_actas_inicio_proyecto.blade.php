<div class="row card card-panel teal lighten-5">
    <h6 class="font-bold">Para descargar las actas de inicio de proyectos finalizados debe seleccionar un rango de fechas de proyectos finalizados y luego presionar el botón de desarga.</h6>
    <div class="row">
        <div class="input-field col s12 m4 l4">
            <select multiple name="selectNodos_actas_inicio_finalizados[]" id="selectNodos_actas_inicio_finalizados" style="width: 100%">
                @if ($nodos->count() >= 2)
                    <option value="all" selected>Todos</option>
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">
                            {{$nodo->nodos}}
                        </option>
                    @endforeach
                @else
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}" selected>
                            {{$nodo->nodos}}
                        </option>
                    @endforeach
                @endif
            </select>
            <label for="selectNodos_actas_inicio_finalizados">Seleccione el nodo</label>
        </div>
        <div class="input-field col s12 m4 l4">
            <input type="text" id="txtacta_inicio_desde_finalizados" name="txtacta_inicio_desde_finalizados" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtacta_inicio_desde_finalizados">Finalizados desde</label>
        </div>
        <div class="input-field col s12 m4 l4">
            <input type="text" id="txtacta_inicio_hasta_finalizados" name="txtacta_inicio_hasta_finalizados" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtacta_inicio_hasta_finalizados">Finalizados hasta</label>
        </div>
    </div>
    <div class="center input-field col s12 m6 l6">
        <a onclick="generarComprimidoConActasInicio(event);" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs">Descargar<i class="material-icons left">file_download</i></a>
    </div>
</div>
