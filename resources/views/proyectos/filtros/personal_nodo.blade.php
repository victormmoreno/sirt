<div class="row">
    <div class="col s12 m12 l12">
      <ul class="tabs" style="width: 100%;">
        <li class="tab col s3"><a href="#proyectos_por_nodo" class="active">Proyectos del nodo</a></li>
        <li class="tab col s3"><a class="" href="#proyectos_por_gestor">Proyectos por experto</a></li>
        <div class="indicator" style="right: 580.5px; left: 0px;"></div>
      </ul>
      <br>
    </div>
  </div>
  <div id="proyectos_por_nodo">
    <div class="row">
      <div class="col s12 m12 l12">
        <div class="input-field col s12 m12 l12">
          <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho" onchange="consultarProyectosUnNodoPorAnho();">
            {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
            @for ($i=2016; $i <= $year; $i++)
              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
            @endfor
          </select>
          <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
        </div>
      </div>
    </div>
  </div>
  <div id="proyectos_por_gestor">
    <span>
      Para consultar los proyectos de un gestor, debes seleccionar el año (de la fecha de cierre de los proyectos), luego un gestor del nodo y por último presionar el
      botón <b>"Consultar proyectos"</b>.
    </span>
    <br><br>
    <div class="row">
      <div class="input-field col s12 m6 l6">
        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorAnhoGestorNodo" name="anho_proyectoPorAnhoGestorNodo">
          {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
          @for ($i=2016; $i <= $year; $i++)
            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
          @endfor
        </select>
        <label for="anho_proyectoPorAnhoGestorNodo">Seleccione el Año</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <select id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
          <option value="">Seleccione primero un nodo</option>
        </select>
        <label for="txtgestor_id">Experto</label>
      </div>
    </div>
  </div>
  @include('proyectos.table')