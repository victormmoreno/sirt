@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          library_books
                      </i>
                      Proyectos de Base Tecnológica
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Proyectos</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Proyectos de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }} </span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs" style="width: 100%;">
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
                      <option value="">Seleccione un gestor del nodo</option>
                      @foreach($gestores as $id => $nombres_gestor)
                        <option value="{{$id}}">{{$nombres_gestor}}</option>
                      @endforeach
                    </select>
                    <label for="txtgestor_id">Gestor</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m4 l4 offset-l4">
                    <a onclick="consulta();" href="javascript:void(0)">
                      <div class="card blue">
                        <div class="card-content center">
                          <i class="left material-icons white-text">search</i>
                          <span class="white-text">Consultar proyectos</span>
                        </div>
                      </div>
                    </a>
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
  $("#codigo_proyecto_tblproyectosDelGestorPorAnho").keyup(function(){
    $('#tblproyectosDelGestorPorAnho').DataTable().draw();
  });

  $("#gestor_tblproyectosDelGestorPorAnho").keyup(function(){
    $('#tblproyectosDelGestorPorAnho').DataTable().draw();
  });

  $("#nombre_tblproyectosDelGestorPorAnho").keyup(function(){
    $('#tblproyectosDelGestorPorAnho').DataTable().draw();
  });

  $("#nombre_fase_tblproyectosDelGestorPorAnho").keyup(function(){
    $('#tblproyectosDelGestorPorAnho').DataTable().draw();
  });

  $("#sublinea_nombre_tblproyectosDelGestorPorAnho").keyup(function(){
    $('#tblproyectosDelGestorPorAnho').DataTable().draw();
  });
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
        "lengthChange": false,
        ajax:{
          url: "/proyecto/datatableProyectosDelGestorPorAnho/"+gestor+"/"+anho,
          data: function (d) {
            d.codigo_proyecto = $('#codigo_proyecto_tblproyectosDelGestorPorAnho').val(),
            d.gestor = $('#gestor_tblproyectosDelGestorPorAnho').val(),
            d.nombre = $('#nombre_tblproyectosDelGestorPorAnho').val(),
            d.sublinea_nombre = $('#sublinea_nombre_tblproyectosDelGestorPorAnho').val(),
            d.nombre_fase = $('#nombre_fase_tblproyectosDelGestorPorAnho').val(),
            d.search = $('input[type="search"]').val()
          }
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
            data: 'nombre_fase',
            name: 'nombre_fase',
          },
          {
                width: '8%',
                data: 'info',
                name: 'info',
                orderable: false
           },
          {
            width: '8%',
            data: 'proceso',
            name: 'proceso',
            orderable: false
          },
          
          ],
        });
    }
    }
  </script>
@endpush
