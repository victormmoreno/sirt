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
              <div class="col s12 m10 l10">
                <div class="center-align">
                  <span class="card-title center-align">Articulaciones de Tecnoparque</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="input-fiel col s12 m12 l12">
                <i class="material-icons">domain</i>
                <label for="txtnodo">Nodo</label>
                <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarLasArticulacionesDeUnNodo(this.value)">
                  <option value="">Seleccione Nodo * </option>
                  @foreach($nodos as $nodo)
                    <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
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
  function consultarLasArticulacionesDeUnNodo(id) {
    $('#articulacionesNodo_table').dataTable().fnDestroy();
    $('#articulacionesNodo_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/articulacion/datatableArticulacionesDelNodo/"+id,
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
</script>
@endpush
