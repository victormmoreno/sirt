@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('meta-content', 'Charlas Informativas')
@section('meta-keywords', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          record_voice_over
                      </i>
                      Charlas Informartivas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Charlas Informartivas</li>
                  </ol>
              </div>
          </div>
          <div class="card stats-card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="center-align">
                    <span class="card-title center-align"> Charlas Informativas de Red Tecnoparque</span>
                    <div class="divider"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-fiel col s12 m12 l12">
                    <label class="active" for="txtnodo">Nodo <span class="red-text">*</span></label>
                    <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="datatableCharlasInformativasPorNodo(this.value)">
                      <option value="">Seleccione nodo</option>
                      @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                      @endforeach
                    </select>
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
  </main>
  @include('charlas.modals')
@endsection
@push('script')
  <script>
  $(document).ready(function() {
    datatableCharlasInformativasPorNodo(id);
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
