<div class="row card card-panel teal lighten-5">
    <h6 class="font-bold">Para consultar los indicadores ÚNICAMENTE DE ARTICULACIONES FINALIZADAS Y CONCLUIDAS SIN FINALIZAR, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
    <h6 class="font-bold">Recordar que se está mostrando la fase ACTUAL de la articulación.</h6>
    @can('showIndicadoresArticulacionOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txtnodo_articulaciones_finalizadas" id="txtnodo_articulaciones_finalizadas" style="width: 100%">
                    <option value="all">Todos</option>
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_articulaciones_finalizadas" class="active">Seleccione el nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_articulaciones_finalizadas" id="txthoja_articulaciones_finalizadas" style="width: 100%">
                    <option value="articulaciones">Articulaciones</option>
                    <option value="talentos">Talentos</option>
                </select>
                <label for="txthoja_articulaciones_finalizadas" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_inicio_finalizadas" name="txtfecha_inicio_finalizadas" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtfecha_inicio_finalizadas">Finalizadas desde</label>
        </div>
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_fin_finalizadas" name="txtfecha_fin_finalizadas" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtfecha_fin_finalizadas">Finalizadas hasta</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelIndicadoresArticulacionesFinalizadas();" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs"><i class="material-icons left">file_download</i>Descargar</a>
        </div>
    </div>
</div>
