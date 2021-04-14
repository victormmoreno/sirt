@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5>
                    <a class="footer-text left-align" href="{{route('entrenamientos')}}">
                      <i class="left material-icons">arrow_back</i>
                    </a> Talleres de fortalecimiento
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('entrenamientos')}}">Talleres de fortalecimiento</a></li>
                      <li class="active">Evidencias</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                @include('entrenamientos.evidencias')
                <div class="divider"></div>
                @include('entrenamientos.tabla_evidencias')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
  datatableArchivosDeUnEntrenamiento();
  function datatableArchivosDeUnEntrenamiento() {
    $('#archivosDeUnEntrenamiento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "/entrenamientos/datatableArchivosDeUnEntrenamiento/"+{{$entrenamiento->id}},
        type: "get",
      },
      columns: [
        {
          data: 'file',
          name: 'file',
          orderable: false,
        },
        {
          data: 'download',
          name: 'download',
          orderable: false,
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
  }
  </script>
@endpush
