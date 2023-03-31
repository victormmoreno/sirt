<div class="row card card-panel teal lighten-5">
    <h6>Para consultar los indicadores ÚNICAMENTE DE PROYECTOS FINALIZADOS Y CONCLUIDOS SIN FINALIZAR, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
    <h6>Recordar que se está mostrando la fase ACTUAL del proyecto.</h6>
    @can('showIndicadoresProyectoOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txtnodo_id_finalizados" id="txtnodo_id_finalizados" style="width: 100%">
                    <option value="all">Todos</option>
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_id_finalizados" class="active">Seleccione el nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_nombre_finalizados" id="txthoja_nombre_finalizados" style="width: 100%">
                    <option value="empresas_duenhas">Empresas dueñas de propiedad intelectual</option>
                    <option value="grupos_duenhos">Grupos de investigación dueñas de propiedad intelectual</option>
                    <option value="personas_duenhas">Personas dueñas de propiedad intelectual</option>
                    <option value="proyectos">Proyectos</option>
                    <option value="tal_ejecutores">Talentos ejecutores</option>
                </select>
                <label for="txthoja_nombre_finalizados" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_inicio_cerrados" name="txtfecha_inicio_cerrados" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtfecha_inicio_cerrados">Finalizados desde</label>
        </div>
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_fin_cerrados" name="txtfecha_fin_cerrados" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtfecha_fin_cerrados">Finalizados hasta</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelConTodosLosIndicadoresFinalizados();" class="btn"><i class="material-icons left">file_download</i>Descargar</a>
        </div>
    </div>
</div>