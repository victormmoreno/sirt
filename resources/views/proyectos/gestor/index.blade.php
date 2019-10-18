@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  @php
  $year = Carbon\Carbon::now();
  $year = $year->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">library_books</i>Proyectos</h5>
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
                      <a href="{{ route('proyecto.create') }}">
                        <div class="card green">
                          <div class="card-content center">
                            <i class="left material-icons white-text">add</i>
                            <span class="white-text">Nuevo Proyecto</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                        <li class="tab col s3"><a href="#proyectos" class="active">Proyectos</a></li>
                        <li class="tab col s3"><a class="" href="#proyectos_pendientes">Pendiente de Aprobación</a></li>
                        <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                      </ul>
                      <br>
                    </div>
                  </div>
                  <div id="proyectos">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s12 m12 l12">
                          <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorAnhoGestorNodo" name="anho_proyectoPorAnhoGestorNodo" onchange="consultarProyectosDelGestorPorAnho();">
                            @for ($i=2016; $i <= $year; $i++)
                              <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                            @endfor
                          </select>
                          <label for="anho_proyectoPorAnhoGestorNodo">Seleccione el Año</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="right material-icons">
                        <a onclick="generarExcelDeProyectosDelGestorPorAnho()">
                          <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                        </a>
                      </div>
                      @include('proyectos.table')
                      <div class="col s12 m2 l2">
                        <a onclick="generarExcelDeProyectosDelGestorPorAnho()" href="javascript:void(0)">
                          <div class="card green">
                            <div class="card-content center">
                              <span class="white-text">Descargar tabla</span>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div id="proyectos_pendientes">
                    @include('proyectos.table_pendientes')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('proyectos.modals')
  </main>
@endsection
@push('script')
  <script>
  consultarProyectosPendientesPorAprobacion();
  function generarExcelDeProyectosDelGestorPorAnho() {
    let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
    location.href = '/excel/excelProyectosDelGestorPorAnho/'+{{ auth()->user()->gestor->id }}+'/'+anho
  }
  </script>
@endpush
