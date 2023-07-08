<div class="row card-panel teal lighten-5">
    <h6 class="font-bold">Para consultar TODOS los indicadores, debes seleccionar un nodo, un rango de fechas y luego presionar el botón de descarga.</h6>
    @can('showIndicadoresArticulacionOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txtnodo_articulacion_todos" id="txtnodo_articulacion_todos" style="width: 100%">
                    <option value="all">Todos</option>
                    @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                </select>
                <label for="txtnodo_articulacion_todos" class="active">Seleccione el Nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_articulacion_todos" id="txthoja_articulacion_todos" style="width: 100%">
                    <option value="articulaciones">Articulaciones</option>
                    <option value="talentos">Talentos</option>
                </select>
                <label for="txthoja_articulacion_todos" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_inicio_articulacion_todos" name="txtfecha_inicio_articulacion_todos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtfecha_inicio_articulacion_todos">Fecha Inicio</label>
        </div>
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_fin_articulacion_todos" name="txtfecha_fin_articulacion_todos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtfecha_fin_articulacion_todos">Fecha Fin</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelConTodosLosIndicadoresArticulaciones();" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs">Descargar<i class="material-icons left">file_download</i></a>
        </div>
    </div>
</div>
