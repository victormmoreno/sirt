<div class="row card card-panel teal lighten-5">
    <h6>Para consultar los indicadores ÚNICAMENTE DE Articulaciones EN FASE DE INICIO, EJECUCIÓN Y CIERRE, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
    <h6>Recordar que se está mostrando la fase ACTUAL de la articulación.</h6>
    @can('showIndicadoresProyectoOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select name="txtnodo_id_actuales[]" id="txtnodo_id_actuales" style="width: 100%">
                    <option value="all">Todos</option>
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">
                        {{$nodo->nodos}}
                    </option>
                @endforeach
                </select>
                <label for="txtnodo_id_actuales" class="active">Seleccione el nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_nombre_actuales" id="txthoja_nombre_actuales" style="width: 100%">
                    <option value="proyectos">Proyectos</option>
                    <option value="tal_ejecutores">Talentos ejecutores</option>
                </select>
                <label for="txthoja_nombre_actuales" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="center input-field col s12 m6 l6">
        <a onclick="generarExcelConTodosLosIndicadoresActuales();" class="btn">Descargar<i class="material-icons left">file_download</i></a>
    </div>
</div>
