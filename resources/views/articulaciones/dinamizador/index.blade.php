@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  @php
  $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY');
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          autorenew
                      </i>
                      Articulaciones con Grupos de Investigación
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Articulaciones G.I</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="center-align">
                    <span class="card-title">Articulaciones G.I - Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <ul class="tabs" style="width: 100%;">
                    <li class="tab col s3"><a href="#articulaciones_por_nodo" class="active">Articulaciones del Nodo</a></li>
                    <li class="tab col s3"><a href="#articulaciones_por_gestor">Articulaciones por Gestor</a></li>
                    <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                  </ul>
                  <br>
                </div>
              </div>
              <div id="articulaciones_por_gestor">
                <div class="col s12 m6 l6">
                  <div class="input-field">
                    <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Gestor" name="txtanho_articulaciones_Gestor" onchange="consultarArticulacionesNodo(this.value);">
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_articulaciones_Gestor">Seleccione el Año</label>
                  </div>
                </div>
                <div class="input-field col s12 m6 l6">
                  <select class="initialized" id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione un gestor del nodo * </option>
                    @foreach($gestores as $id => $nombres_gestor)
                      <option value="{{$id}}">{{$nombres_gestor}}</option>
                    @endforeach
                  </select>
                  <label for="txtgestor_id">Gestor</label>
                </div>
                <div class="row">
                  <div class="col s12 m4 l4 offset-l4">
                    <a onclick="consultarArticulacionesGestor();" href="javascript:void(0)">
                      <div class="card blue">
                        <div class="card-content center flow-text">
                          <i class="left material-icons white-text small">search</i>
                          <span class="white-text">Consultar Articulaciones G.I</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div id="articulaciones_por_nodo">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m12 l12">
                      <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Nodo" name="txtanho_articulaciones_Nodo" onchange="consultarArticulacionesNodo(this.value);">
                        @for ($i=2016; $i <= $year; $i++)
                          <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                        @endfor
                      </select>
                      <label for="txtanho_articulaciones_Nodo">Seleccione el Año</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <div class="row">
                @include('articulaciones.table')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('articulaciones.modals')
@endsection
@push('script')
  <script>
    consultarArticulacionesNodo({{ $year }});
    function consultarArticulacionesNodo(anho) {
      $('#articulacionesNodo_table').dataTable().fnDestroy();
      $('#articulacionesNodo_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        // searching: false,
        ajax:{
          url: "/articulacion/datatableArticulacionesDelNodo/"+0+"/"+anho,
          data: function (d) {
            d.codigo_articulacion = $('#codigo_articulacion_DinamizadorTable').val(),
            d.nombre_gestor = $('#nombre_GestorDinamizadorTable').val(),
            d.nombre = $('#nombre_DinamizadorTable').val(),
            d.fase = $('#fase_DinamizadorTable').val(),
            d.search = $('input[type="search"]').val()
          }
        },
        columns: [
        {
          data: 'codigo_articulacion',
          name: 'codigo_articulacion',
        },
        {
          data: 'nombre_completo_gestor',
          name: 'nombre_completo_gestor',
        },
        {
          data: 'nombre',
          name: 'nombre',
        },
        {
          data: 'nombre_fase',
          name: 'nombre_fase',
        },
        {
          data: 'proceso',
          name: 'proceso',
          orderable: false
        },
        ],
      });
    }

    $("#codigo_articulacion_DinamizadorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#nombre_GestorDinamizadorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#nombre_DinamizadorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $("#fase_DinamizadorTable").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    function consultarArticulacionesGestor() {
      let anho = $('#txtanho_articulaciones_Gestor').val();
      let id = $('#txtgestor_id').val();
      $('#articulacionesNodo_table').dataTable().fnDestroy();
      $('#articulacionesNodo_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/articulacion/datatableArticulacionesDelGestor/"+id+"/"+anho,
          data: function (d) {
            d.codigo_articulacion = $('.codigo_articulacion').val(),
            d.nombre = $('.nombre').val(),
            d.tipo_articulacion = $('.tipo_articulacion').val(),
            d.nombre_completo_gestor = $('.nombre_completo_gestor').val(),
            d.estado = $('.estado').val(),
            d.search = $('input[type="search"]').val()
          }
          // type: "get",
        },
        columns: [
          {
          data: 'codigo_articulacion',
          name: 'codigo_articulacion',
        },
        {
          data: 'nombre_completo_gestor',
          name: 'nombre_completo_gestor',
        },
        {
          data: 'nombre',
          name: 'nombre',
        },
        {
          data: 'nombre_fase',
          name: 'nombre_fase',
        },
        {
          data: 'proceso',
          name: 'proceso',
          orderable: false
        },
        ],
      });
    }
  </script>
@endpush
