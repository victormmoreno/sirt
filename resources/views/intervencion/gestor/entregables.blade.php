@extends('layouts.app')
@section('meta-title', 'Intervención a Empresas')
@section('meta-content', 'Intervención a Empresas')
@section('meta-keywords', 'Intervención a Empresas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
            <div class="col s12 m8 l9">
                <h5 class="left-align">
                  <a class="footer-text left-align" href="{{route('intervencion.index')}}">
                    <i class="left material-icons">arrow_back</i>
                  </a>
                  Entregables Intervención a Empresas
                </h5>
            </div>
            <div class="col12 s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('intervencion.index')}}">Intervención a Empresas</a></li>
                    <li class="active">Entregables</li>
                </ol>
            </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form onsubmit="return checkSubmit()" method="post" action="{{ route('articulacion.update.entregables', $articulacion->id) }}">
                  @include('intervencion.form_entregables')
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
                              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivoDeUnaIntervencion">
                                <thead>
                                  <tr>
                                    <th>Archivo</th>
                                    <th>Fase</th>
                                    <th style="width: 10%">Descargar</th>
                                    <th style="width: 10%">Eliminar</th>
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
    $('#archivoDeUnaIntervencion').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: host_url + "/intervencion/archivosDeUnaArticulacion/"+{{$articulacion->id}},
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
        {
          data: 'delete',
          name: 'delete',
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

  var DropzoneArticulacionCierre = new Dropzone('#fase_cierre_articulacion', {
    url: host_url + '/articulacion/store/{{ $articulacion->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Cierre'
    },
    paramName: 'nombreArchivo'
  });

  var DropzoneArticulacionEjecucion = new Dropzone('#fase_ejecucion_articulacion', {
    url: host_url + '/articulacion/store/{{ $articulacion->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Ejecución'
    },
    paramName: 'nombreArchivo'
  });

  var DropzoneArticulacionInicio = new Dropzone('#fase_inicio_articulacion', {
    url: host_url + '/articulacion/store/{{ $articulacion->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Inicio'
    },
    paramName: 'nombreArchivo'
  });

  DropzoneArticulacionInicio.on('success', function (res) {
    $('#archivoDeUnaIntervencion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneArticulacionEjecucion.on('success', function (res) {
    $('#archivoDeUnaIntervencion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneArticulacionCierre.on('success', function (res) {
    $('#archivoDeUnaIntervencion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneArticulacionInicio.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'El archivo no se ha podido subir!'
    });
  })

  DropzoneArticulacionEjecucion.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'El archivo no se ha podido subir!'
    });
  })

  DropzoneArticulacionCierre.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'error',
      title: 'El archivo no se ha podido subir!'
    });
  })
  Dropzone.autoDiscover = false;
  </script>
@endpush
