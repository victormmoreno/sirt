@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5><i class="material-icons">library_books</i>Proyectos</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Proyectos de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }} </span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a href="#proyectos_por_nodo" class="active">Proyectos del Nodo</a></li>
                    <li class="tab col s3"><a class="" href="#proyectos_por_gestor">Proyectos por Gestor</a></li>
                    <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                  </ul>
                  <br>
                </div>
              </div>
              <div id="proyectos_por_nodo">
                <div class="row">
                  <div class="col s12 m12 l12">
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
                </div>
                <div class="row">
                  @include('proyectos.table')
                </div>
              </div>
              <div id="proyectos_por_gestor">
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
                      <option value="">Seleccione el Gestor</option>
                      @foreach($gestores as $id => $nombres_gestor)
                        <option value="{{$id}}">{{$nombres_gestor}}</option>
                      @endforeach
                    </select>
                    <label for="txtgestor_id">Gestor</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12 center">
                    <a class="btn-floating blue" onclick="consulta();"><i class="material-icons left">search</i>Buscar</a>
                    {{-- <a class="waves-effect waves-light btn" onclick="consulta();"><i class="material-icons left">cloud</i>button</a> --}}
                  </div>
                </div>
                <div class="row">
                  @include('proyectos.table2')
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
@push('script')
  <script>
  // Ajax que muestra los proyectos de un gestor por año
  function consulta() {
    let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
    let gestor = $('#txtgestor_id').val();
    if (gestor == "") {
      Swal.fire({
        title: 'Error!',
        text: "Debes seleccionar un gestor!",
        type: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
      })
    } else {
      $('#tblproyectosDelGestorPorAnho').dataTable().fnDestroy();
      $('#tblproyectosDelGestorPorAnho').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/proyecto/datatableProyectosDelGestorPorAnho/"+gestor+"/"+anho,
          type: "get",
        },
        columns: [
          {
            width: '15%',
            data: 'codigo_proyecto',
            name: 'codigo_proyecto',
          },
          {
            data: 'gestor',
            name: 'gestor',
          },
          {
            data: 'nombre',
            name: 'nombre',
          },
          {
            data: 'sublinea_nombre',
            name: 'sublinea_nombre',
          },
          {
            data: 'estado_nombre',
            name: 'estado_nombre',
          },
          {
            data: 'revisado_final',
            name: 'revisado_final',
          },
          {
            width: '8%',
            data: 'talentos',
            name: 'talentos',
            orderable: false
          },
          {
            width: '8%',
            data: 'details',
            name: 'details',
            orderable: false
          },
          {
            width: '8%',
            data: 'edit',
            name: 'edit',
            orderable: false
          },
          {
            width: '8%',
            data: 'entregables',
            name: 'entregables',
            orderable: false
          },
          ],
        });
    }
    }
  </script>
@endpush
