@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons">autorenew</i>Articulaciones</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="center-align">
                  <span class="card-title">Articulaciones - Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m12 l12">
                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                  <li class="tab col s3"><a href="#articulaciones_por_nodo" class="active">Articulaciones del Nodo</a></li>
                  <li class="tab col s3"><a class="" href="#articulaciones_por_gestor">Articulaciones por Gestor</a></li>
                  <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                </ul>
                <br>
              </div>
            </div>
            <div id="articulaciones_por_gestor">
              <div class="input-fiel col s12 m12 l12">
                <i class="material-icons">domain</i>
                <label for="txtgestor_id">Gestor</label>
                <select class="initialized" id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1" onchange="consultarArticulacionesGestor(this.value)">
                  <option value="">Seleccione el Gestor * </option>
                  @foreach($gestores as $id => $nombres_gestor)
                    <option value="{{$id}}">{{$nombres_gestor}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="divider"></div>

            @include('articulaciones.table')
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
  consultarArticulacionesNodo();
  function consultarArticulacionesNodo() {
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
        url: "/articulacion/datatableArticulacionesDelNodo/"+0,
        // type: "get",
        data: function (d) {
          d.codigo_articulacion = $('.codigo_articulacion').val(),
          d.nombre = $('.nombre').val(),
          d.tipo_articulacion = $('.tipo_articulacion').val(),
          d.nombre_completo_gestor = $('.nombre_completo_gestor').val(),
          d.estado = $('.estado').val(),
          d.search = $('input[type="search"]').val()
        }
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
          data: 'tipo_articulacion',
          name: 'tipo_articulacion',
        },
        {
          data: 'nombre_completo_gestor',
          name: 'nombre_completo_gestor',
        },
        {
          width: '15%',
          data: 'estado',
          name: 'estado',
        },
        {
          data: 'revisado_final',
          name: 'revisado_final',
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
        {
          data: 'edit',
          name: 'edit',
          orderable: false
        },
        ],
      });
    }

    $(".codigo_articulacion").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $(".nombre").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $(".tipo_articulacion").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $(".nombre_completo_gestor").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

    $(".estado").keyup(function(){
      $('#articulacionesNodo_table').DataTable().draw();
    });

  function consultarArticulacionesGestor(id) {
    $('#articulacionesNodo_table').dataTable().fnDestroy();
    $('#articulacionesNodo_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/articulacion/datatableArticulacionesDelGestor/"+id,
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
          data: 'nombre',
          name: 'nombre',
        },
        {
          data: 'tipo_articulacion',
          name: 'tipo_articulacion',
        },
        {
          data: 'nombre_completo_gestor',
          name: 'nombre_completo_gestor',
        },
        {
          width: '15%',
          data: 'estado',
          name: 'estado',
        },
        {
          data: 'revisado_final',
          name: 'revisado_final',
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
  </script>
@endpush
