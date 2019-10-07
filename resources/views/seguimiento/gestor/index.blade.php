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
          <h5><i class="left material-icons">search</i>Seguimiento</h5>
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
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio_Gestor" name="txtfecha_inicio_Gestor" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                        <label for="txtfecha_inicio_Gestor">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_fin_Gestor" name="txtfecha_fin_Gestor" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                        <label for="txtfecha_fin_Gestor">Fecha Fin</label>
                      </div>
                      <div class="center col s12 m6 l6">
                        <button onclick="consultarSeguimientoDeUnGestor(0)" class="btn">Consultar</button>
                      </div>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
