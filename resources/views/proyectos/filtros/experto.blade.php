<div id="proyectos">
    <div class="row">
    <div class="col s12 m12 l12">
        <div class="input-field col s12 m12 l12">
        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho" onchange="consultarProyectosUnNodoPorAnho();">
            @for ($i=2016; $i <= $year; $i++)
            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
            @endfor
        </select>
        <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
        </div>
    </div>
    </div>
    <div class="row">
    @include('proyectos.table')
    </div>
</div>