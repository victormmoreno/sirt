@extends('layouts.app')
@section('meta-title', 'Intervención a Empresas')
@section('meta-content', 'Intervención a Empresas')
@section('meta-keywords', 'Intervención a Empresas')

@section('content')
  @php
  $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY');
  @endphp
  <link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
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
                      Intervención a Empresas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Intervención a Empresas</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m10 l10">
                  <div class="center-align">
                    <span class="card-title center-align">Intervención a Empresas</span>
                  </div>
                </div>
              </div>
              <div class="divider"></div><br>
              <div class="row">
                <div class="input-field col s12 m6 l6">
                  <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_articulaciones_Nodo" name="txtanho_articulaciones_Nodo">
                    @for ($i=2016; $i <= $year; $i++)
                      <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                    @endfor
                  </select>
                  <label for="txtanho_articulaciones_Nodo">Seleccione el Año</label>
                </div>
                <div class="input-field col s12 m6 l6">
                  <select class="initialized" id="txtnodo_id" name="txtnodo_id" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Nodo * </option>
                    @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                  </select>
                  <label for="txtnodo_id">Seleccione un Nodo</label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 m4 l4 offset-l4">
                  <a onclick="consultarLasArticulacionesDeUnNodo();" href="javascript:void(0)">
                    <div class="card blue">
                      <div class="card-content center flow-text">
                        <i class="left material-icons white-text small">search</i>
                        <span class="white-text">Consultar Intervención a Empresas</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="divider"></div>
              @include('intervencion.table')
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
    $(document).ready(function() {
      $('#intervencionesNodo_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          }
      });
    });
    function consultarLasArticulacionesDeUnNodo() {
      let id = $('#txtnodo_id').val();
      let anho = $('#txtanho_articulaciones_Nodo').val();
      if (id === '') {
        Swal.fire('Advertencia!', 'Seleccione un nodo', 'warning');
      } else {
        
        $('#intervencionesNodo_table').dataTable().fnDestroy();
        $('#intervencionesNodo_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/intervencion/datatableIntervencionesDelNodo/"+id+"/"+anho,
            data: function (d) {
              d.codigo_articulacion = $('.codigo_articulacion').val(),
              d.nombre = $('.nombre').val(),
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
              data: 'nombre',
              name: 'nombre',
            },
            
            {
              data: 'nombre_completo_gestor',
              name: 'nombre_completo_gestor',
            },
            {
              data: 'estado',
              name: 'estado',
            },
            {
              data: 'details',
              name: 'details',
              orderable: false
            },
            {
              data: 'entregables',
              name: 'entregables',
              orderable: false
            },
            ],
          });
      }
    }

    $(".codigo_articulacion").keyup(function(){
      $('#intervencionesNodo_table').DataTable().draw();
    });

    $(".nombre").keyup(function(){
      $('#intervencionesNodo_table').DataTable().draw();
    });

    $(".nombre_completo_gestor").keyup(function(){
      $('#intervencionesNodo_table').DataTable().draw();
    });

    $(".estado").keyup(function(){
      $('#intervencionesNodo_table').DataTable().draw();
    });
  </script>
@endpush
