@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5>
                    <a class="footer-text left-align" href="{{route('articulacion')}}" rel="nofollow">
                      <i class="material-icons arrow-l">arrow_back</i>
                    </a> Articulaciones
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('intervencion.index')}}">Articulaciones</a></li>
                      <li class="active">Entregables</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form onsubmit="return checkSubmit()" method="post" action="{{ route('articulacion.update.entregables', $articulacion->id) }}">
                  @include('articulaciones.form_entregables')
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                    <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <ul class="collapsible" data-collapsible="accordion">
                      <li>
                        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para ver los entregables de la articulación</div>
                        <div class="collapsible-body">
                          <div class="row">
                            <div class="col s12 m12 l12">
                              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivoDeUnaArticulacion">
                                <thead>
                                  <tr>
                                    <th>Archivo</th>
                                    <th>Fase</th>
                                    <th style="width: 10%">Descargar</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div id="modalContenidoActaInicio" class="modal">
    <div class="modal-content">
      <h4>El acta de inicio debe llevar</h4>
      <ul class="collection">
        <li class="collection-item">Párrafo donde se definan los productos de la articulación.</li>
        <li class="collection-item">Debe incluir la firma del líder del grupo de investigación.</li>
        <li class="collection-item">Pantallazo del GrupLac de Colciencias donde se evidencie la institución que avala el grupo y la categoría a la fecha.</li>
        <li class="collection-item">Para grupos de investigación SENA: Incluir el código de registro en SGPS de los proyectos con recursos aprobados.</li>
      </ul>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
    </div>
  </div>
@endsection
@push('script')
  <script>
  datatableArchivosDeUnaArticulacion();
  function datatableArchivosDeUnaArticulacion() {
    $('#archivoDeUnaArticulacion').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "/articulacion/archivosDeUnaArticulacion/"+{{$articulacion->id}},
        type: "get",
      },
      columns: [
        {
          data: 'file',
          name: 'file',
          orderable: false,
        },
        {
          data: 'fase',
          name: 'fase',
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
