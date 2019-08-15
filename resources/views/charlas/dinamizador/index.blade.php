@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons left">record_voice_over</i>Charlas Informativas</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Charlas Informativas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  @include('charlas.table')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('charlas.modals')
@endsection
@push('script')
  <script>
  $(document).ready(function() {
    datatableCharlasInformativasPorNodo({{auth()->user()->dinamizador->nodo_id}});
  });
  function datatableCharlasInformativasPorNodo(id) {
    $('#charlasInformativasNodo_table').dataTable().fnDestroy();
    $('#charlasInformativasNodo_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/charla/consultarCharlasInformativasPorNodo/"+id,
        type: "get",
      },
      columns: [
        { width: '15%', data: 'codigo_charla', name: 'codigo_charla' },
        { data: 'fecha', name: 'fecha' },
        { data: 'nodo', name: 'nodo' },
        { data: 'encargado', name: 'encargado' },
        { data: 'nro_asistentes', name: 'nro_asistentes' },
        { width: '8%', data: 'details', name: 'details', orderable: false },
        { width: '8%', data: 'evidencias', name: 'evidencias', orderable: false }
      ],
    });
  }
  </script>
@endpush
