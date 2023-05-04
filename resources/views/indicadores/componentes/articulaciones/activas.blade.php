<div class="row card card-panel teal lighten-5">
    <h6>Para consultar los indicadores ÚNICAMENTE DE Articulaciones EN FASE DE INICIO, EJECUCIÓN Y CIERRE, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
    <h6>Recordar que se está mostrando la fase ACTUAL de la articulación.</h6>
    @can('showIndicadoresArticulacionOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txtnodo_articulaciones_activas" id="txtnodo_articulaciones_activas" style="width: 100%">
                    <option value="all">Todos</option>
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">
                            {{$nodo->nodos}}
                        </option>
                    @endforeach
                </select>
                <label for="txtnodo_articulaciones_activas" class="active">Seleccione el nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_articulaciones_activas" id="txthoja_articulaciones_activas" style="width: 100%">
                    <option value="articulaciones">Articulaciones</option>
                    <option value="talentos">Talentos</option>
                </select>
                <label for="txthoja_articulaciones_activas" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="center input-field col s12 m6 l6 offset-m1 offset-l1">
            <a onclick="generarExcelIndicadoresArticulacionesActuales();" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button right m-l-xs">Descargar<i class="material-icons left">file_download</i></a>
        </div>
    </div>
</div>
