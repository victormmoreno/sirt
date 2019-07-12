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
                  <div class="row">
                    <div class="col s12 m10 l10">
                      <div class="center-align">
                        <span class="card-title center-align">Proyectos de {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                      </div>
                    </div>
                    <div class="col s12 m2 l2">
                      <div class="click-to-toggle show-on-large hide-on-med-and-down">
                        <a href="{{route('proyecto.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="button" data-delay="50" data-tooltip="Nuevo Proyecto">
                          <i class="material-icons">library_add</i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="input-field col s12 m12 l12">
                        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorAnhoGestorNodo" name="anho_proyectoPorAnhoGestorNodo" onchange="consultarProyectosDelGestorPorAnho();">
                          {!!
                            $year = Carbon\Carbon::now();
                            $year = $year->isoFormat('YYYY');
                            !!}
                            @for ($i=2016; $i <= $year; $i++)
                              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                            @endfor
                          </select>
                          <label for="anho_proyectoPorAnhoGestorNodo">Seleccione el Año</label>
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
      <!--boton de abajo -->
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('proyecto.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Proyecto">
          <i class="material-icons">library_add</i>
        </a>
      </div>
    </div>
  </main>
  @include('proyectos.modals')
@endsection
