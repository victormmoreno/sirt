<div class="row card-panel teal lighten-5">
    <h6>Para consultar TODOS los indicadores, debes seleccionar un nodo, un rango de fechas y luego presionar el botón de descarga.</h6>
    @can('showIndicadoresProyectoOptions', Illuminate\Database\Eloquent\Model::class)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <select multiple name="txtnodo_id[]" id="txtnodo_id" style="width: 100%">
                    <option value="all" selected>Todos</option>
                @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @endforeach
                </select>
                <label for="txtnodo_id" class="active">Seleccione el Nodo</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select class="js-states select2 browser-default" name="txthoja_nombre" id="txthoja_nombre" style="width: 100%">
                <option value="empresas_duenhas">Empresas dueñas de propiedad intelectual</option>
                <option value="grupos_duenhos">Grupos de investigación dueñas de propiedad intelectual</option>
                <option value="personas_duenhas">Personas dueñas de propiedad intelectual</option>
                    <option value="proyectos">Proyectos</option>
                    <option value="tal_ejecutores">Talentos ejecutores</option>
                </select>
                <label for="txthoja_nombre" class="active">Seleccione que información desea exportar</label>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_inicio_todos" name="txtfecha_inicio_todos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
            <label for="txtfecha_inicio_todos">Fecha Inicio</label>
        </div>
        <div class="input-field col s12 m3 l3">
            <input type="text" id="txtfecha_fin_todos" name="txtfecha_fin_todos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
            <label for="txtfecha_fin_todos">Fecha Fin</label>
        </div>
        <div class="center input-field col s12 m6 l6">
            <a onclick="generarExcelConTodosLosIndicadores(event, {{request()->user()->getNodoUser()}});" class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat search-tabs-button m-l-xs"><i class="material-icons">file_download</i></a>
        </div>
    </div>
</div>
