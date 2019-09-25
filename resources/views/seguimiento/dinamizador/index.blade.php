@extends('layouts.app')
@section('meta-title', 'Seguimiento')
@section('content')
  @php
  $yearNow = Carbon\Carbon::now()->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="material-icons">search</i>Seguimiento</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    {{-- <li class="tab col s3"><a class="" href="#tecnoparque">Tecnoparque</a></li>  --}}
                    <li class="tab col s3"><a class="" href="#gestor">Gestor</a></li>
                    {{-- <li class="tab col s3"><a class="" href="#linea">Línea</a></li> --}}
                  </ul>
                  <br>
                </div>
                <div id="gestor" class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <div class="input-field col s12 m12 l12">
                        <select id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
                          <option value="">Seleccione el Gestor</option>
                          @foreach($gestores as $id => $nombres_gestor)
                            <option value="{{$id}}">{{$nombres_gestor}}</option>
                          @endforeach
                        </select>
                        <label for="txtgestor_id">Gestor</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" name="txtfecha_inicio" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                        <label for="txtfecha_inicio">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_fin" name="txtfecha_fin" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                        <label for="txtfecha_fin">Fecha Fin</label>
                      </div>
                      <div class="center col s12 m6 l6">
                        <button onclick="consultarSeguimientoDeUnGestor()" class="btn">Consultar</button>
                      </div>
                      {{-- <div class="center col s12 m6 l6">
                        <div class="material-icons">
                          <a onclick="">
                            <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                          </a>
                        </div>
                      </div> --}}
                    </div>
                    <div class="col s12 m8 l8">
                      <div id="graficoSeguimientoPorGestorDeUnNodo_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                          <h5 class="center">
                            Para consultar el seguimiento de un gestor, debes seleccionar en el campo de gestores, luego seleccionar
                            un rango de fecha y por último pulsar el botón de consultar.
                          </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <div id="tecnoparque" class="col s12 m12 l12">
                <div class="row">
                <div class="col s12 m4 l4">
                <div class="row">
                <div class="input-field col s12 m6 l6">
                <input type="text" id="fecha_inicioTecnoparque" name="fecha_inicioTecnoparque" class="datepicker picker__input" value="">
                <label for="fecha_inicioTecnoparque">Fecha Inicio</label>
              </div>
              <div class="input-field col s12 m6 l6">
              <input type="text" id="fecha_finTecnoparque" name="fecha_finTecnoparque" class="datepicker picker__input" value="">
              <label for="fecha_finTecnoparque">Fecha Fin</label>
            </div>
          </div>
          <center>
          <button id="consultarTecnoparque" class="btn">Consultar</button>
          <button id="jsPDFTecnoparque" class="btn red">PDF</button>
        </center>
      </div>
      <div id="idSeguimientoTecnoparque" class="col s12 m8 l8">
      <canvas id="SeguimientoTecnoparque" height="140"></canvas>
    </div>
  </div>
</div> --}}
{{-- <div id="linea" class="col s12 m12 l12">
  <div class="row">
    <div class="col s12 m4 l4">
      <div class="input-field col s12 m12 l12">
        <select class="js-states"  tabindex="-1" style="width: 100%" id="txtidlinea" name="txtidlinea">
          <option value="" selected>Seleccione una Línea</option>

        </select>
      </div>
      <div class="row">
        <div class="input-field col s12 m6 l6">
          <input type="text" id="fecha_inicioLinea" name="fecha_inicioLinea" class="datepicker picker__input" value="">
          <label for="fecha_inicioLinea">Fecha Inicio</label>
        </div>
        <div class="input-field col s12 m6 l6">
          <input type="text" id="fecha_finLinea" name="fecha_finLinea" class="datepicker picker__input" value="">
          <label for="fecha_finLinea">Fecha Fin</label>
        </div>
      </div>
      <center>
        <button id="consultarLinea" class="btn">Consultar</button>
        <button id="jsPDFLinea" class="btn red">PDF</button>
      </center>
    </div>
    <div id="idSeguimientoLinea" class="col s12 m8 l8">
      <canvas id="SeguimientoLinea" height="140"></canvas>
    </div>
  </div>
</div> --}}
</div>
</div>
</div>
</div>
</div>
</div>
</main>
@endsection
@push('script')
  <script>
    $(document).ready(function(){
      // consultarEdtsPorNodoGestorYFecha_stacked(0);
      // consultarEdtsDelNodoPorAnho_variablepie(0);
    });
  </script>
@endpush
