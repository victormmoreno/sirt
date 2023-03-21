@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('meta-content', 'CSIBT')
@section('meta-keywords', 'CSIBT')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          gavel
                      </i>
                      Comité de Selección de Ideas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Comité de Selección de Ideas</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 {{request()->user()->can('create', App\Models\Comite::class) ? 'm10 l10' : 'm12 l12'}}">
                    <h4 class="center">CSIBT de Tecnoparque</h4>
                  </div>
                  @can('create', App\Models\Comite::class)
                    <div class="col s12 m2 l2">
                      <a class="red" href="{{ route('csibt.create') }}">
                        <div class="card green">
                          <div class="card-content center">
                            <i class="left material-icons white-text">add</i>
                            <span class="white-text">Nuevo Comité</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  @endcan
                </div>
                <div class="divider"></div>
                @can('show_filters', App\Models\Comite::class)
                <div class="row">
                  <div class="input-fiel">
                    <label class="active" for="txtnodo">Nodo <span class="red-text">*</span></label>
                    <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarCsibtPorNodo()">
                      <option value="">Seleccione nodo</option>
                      @foreach($nodos as $nodo)
                        <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endcan
                <table class="display responsive-table datatable-example dataTable" id="comitesDelNodo_table" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Código del Comité</th>
                      <th>Fecha</th>
                      <th>Estado del Comité</th>
                      <th>Observaciones</th>
                      <th style="width: 8%">Detalles</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @can('create', App\Models\Comite::class)
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('csibt.create')}}"  class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nuevo Comité">
          <i class="material-icons">gavel</i>
        </a>
      </div>
    @endcan
  </div>
</main>
@endsection
@cannot('show_filters', App\Models\Comite::class)
  @push('script')
    <script>
      $(document).ready(function() {
        $('.dataTables_length select').addClass('browser-default');
          $('#comitesDelNodo_table').DataTable({
            language: {
              "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
              url: host_url + "/csibt/"+{{request()->user()->getNodoUser()}}+"/consultarCsibtPorNodo",
              type: "get",
            },
            columns: [
              {
                data: 'codigo',
                name: 'codigo',
              },
              {
                data: 'fechacomite',
                name: 'fechacomite',
              },
              {
                data: 'estadocomite',
                name: 'estadocomite',
              },
              {
                data: 'observaciones',
                name: 'observaciones',
              },
              {
                data: 'details',
                name: 'details',
                orderable: false
              },
            ],
            initComplete: function () {
              this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                  column.search($(this).val(), false, false, true).draw();
                });
              });
            }
          });
        });
    </script>
      
  @endpush
@endcannot
