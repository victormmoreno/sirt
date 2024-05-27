<div class="row card card-panel teal lighten-5">
    <h6 class="font-bold">Para descargar los resultados de la encuesta debe seleccionar un nodos y luego presionar el botón de descarga.</h6>
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <select multiple name="selectNodos_resultados_encuesta[]" id="selectNodos_resultados_encuesta" style="width: 100%">
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
            <label for="selectNodos_resultados_encuesta">Seleccione el nodo</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelResultadosEncuesta(event);" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs">Descargar<i class="material-icons left">file_download</i></a>
        </div>
    </div>
</div>
