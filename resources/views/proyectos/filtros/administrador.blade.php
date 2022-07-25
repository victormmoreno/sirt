<div class="row">
    <div class="col s12 m12 l12">
    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
        <li class="tab col s3"><a href="#proyectos_por_nodo" class="active">Proyectos Por Nodo</a></li>
        <div class="indicator" style="right: 580.5px; left: 0px;"></div>
    </ul>
    <br>
    </div>
</div>
<div id="proyectos_por_nodo">
    <div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho" onchange="consultarProyectosDelNodoPorAnho();">
            {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
            @for ($i=2016; $i <= $year; $i++)
            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
            @endfor
        </select>
        <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <select class="js-states" name="nodo_proyectoPorNodoYAnho" id="nodo_proyectoPorNodoYAnho" style="width: 100%">
        @foreach($nodos as $nodo)
            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
        @endforeach
        </select>
        <label for="nodo_proyectoPorNodoYAnho">Seleccione el Nodo</label>
    </div>
    </div>

    <div class="row center">
    <div class="col s12 m4 l4 offset-l4">
        <a onclick="consultarProyectosDelNodoPorAnho_Administrador();" href="javascript:void(0)">
        <div class="card blue">
            <div class="card-content center flow-text">
            <i class="left material-icons white-text small">search</i>
            <span class="white-text">Consultar Proyectos</span>
            </div>
        </div>
        </a>
    </div>
    </div>
    <div class="divider"></div>
    <div class="row">
    @include('proyectos.table')
    </div>
</div>