@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="material-icons">library_books</i>Proyectos</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="center-align">
                    <span class="card-title center-align">Proyectos de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }} </span>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m12 l12">
                        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho" onchange="consultarProyectosDelNodoPorAnho();">
                          {!!
                            $year = Carbon\Carbon::now();
                            $year = $year->isoFormat('YYYY');
                            !!}
                            @for ($i=2016; $i <= $year; $i++)
                              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                            @endfor
                          </select>
                          <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    @include('proyectos.gestor.table')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    @include('proyectos.modals')
  @endsection
