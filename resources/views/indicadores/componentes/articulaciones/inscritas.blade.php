<div class="row card card-panel teal lighten-5">
    <h6>Para consultar los indicadores ÚNICAMENTE DE ARTICULACIONES INSCRITAS, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
    <h6>Recordar que se está mostrando la fase ACTUAL de la Articulación.</h6>
    @can('showIndicadoresArticulacionOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select name="txtnodo_articulaciones_inscritas" id="txtnodo_articulaciones_inscritas" style="width: 100%">
                <option value="all">Todos</option>
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_articulaciones_inscritas" class="active">Seleccione el nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_articulaciones_inscritas" id="txthoja_articulaciones_inscritas" style="width: 100%">
                    <option value="articulaciones">Articulaciones</option>
                    <option value="talentos">Talentos</option>

                </select>
                <label for="txthoja_articulaciones_inscritas" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_inicio_articulaciones_inscritas" name="txtfecha_inicio_articulaciones_inscritas" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtfecha_inicio_articulaciones_inscritas">Inscritos desde</label>
        </div>
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_fin_articulaciones_inscritas" name="txtfecha_fin_articulaciones_inscritas" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtfecha_fin_articulaciones_inscritas">Inscritos hasta</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelIndicadoresArticulacionesInscritas();" class="btn"><i class="material-icons left">file_download</i>Descargar</a>
        </div>
    </div>
</div>
