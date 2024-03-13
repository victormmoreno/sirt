<div class="row">
    <div class="input-field col s12 m5 l5">
        <select name="filter_nodo_ingresos" id="filter_nodo_ingresos" style="width: 100%">
        @if (session()->get('login_role') == auth()->user()->IsAuxiliar() || session()->get('login_role') == auth()->user()->IsActivador() || session()->get('login_role') == auth()->user()->IsAdministrador())
            <option value="all" selected>Todos</option>
        @endif
        @foreach($nodos as $nodo)
            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
        @endforeach
        </select>
        <label for="filter_nodo_ingresos">Seleccione el nodo</label>
    </div>
    <div class="input-field col m2 l2 s2">
        <input id="txtstart_date_ingresos" name="txtstart_date_ingresos" type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
        <label for="txtstart_date_ingresos">Desde</label>
    </div>
    <div class="input-field col m2 l2 s2">
        <input id="txtend_date_ingresos" name="txtend_date_ingresos" type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
        <label for="txtend_date_ingresos">Hasta</label>
    </div>
    <div class="input-field col m2 l2 s2">
        <button class="waves-effect waves-grey bg-secondary-lighten white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs" id="download_excel_visitas"><i class="material-icons left">cloud_download</i>Descargar</button>
    </div>
</div>
