@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('articulacion.inicio', $articulacion->id) }}">
          <i class="left material-icons">arrow_back</i>
        </a> Articulaciones con Grupos de Investigación
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <h5 class="center">Entregables de la fase de cierre.</h5>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('articulacion.update.entregables.cierre', $articulacion->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('articulaciones.gestor.form_entregables_cierre')
                <div class="row">
                  @include('articulaciones.archivos_table_fase', ['fase' => 'cierre'])
                </div>
                <center>
                  @if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 0)
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  @endif
                  <a href="{{ route('articulacion.cierre', $articulacion->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
              </form>
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
  datatableArchivosDeUnaArticulacion_cierre();
  var Dropzone = new Dropzone('#fase_cierre_articulacion', {
    url: '{{ route('articulacion.files.upload', $articulacion->id) }}',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Cierre'
    },
    paramName: 'nombreArchivo'
  });

  Dropzone.on('success', function (res) {
    $('#archivosDeUnaArticulacion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion_cierre();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  Dropzone.on('error', function (file, res) {
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

  function datatableArchivosDeUnaArticulacion_cierre() {
  $('#archivosDeUnaArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$articulacion->id, 'Cierre'])}}",
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
      @if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 0)
      {
        data: 'delete',
        name: 'delete',
        orderable: false,
      },
      @endif
    ],
  });
}
</script>
@endpush
