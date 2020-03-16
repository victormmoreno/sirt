@extends('layouts.app')
@section('meta-title', 'Articulaciones con G.I')
@section('content')
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
            <h5 class="center">Entregables de la fase de inicio.</h5>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('articulacion.update.entregables.inicio', $articulacion->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('articulaciones.gestor.form_entregables_inicio')
                @include('articulaciones.archivos_table_fase', ['fase' => 'inicio'])
                <div class="divider"></div>
                <center>
                  @if ($articulacion->fase->nombre == 'Inicio')
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  @endif
                  <a href="{{ route('articulacion.inicio', $articulacion->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
    datatableArchivosDeUnaArticulacion_inicio();
  var Dropzone = new Dropzone('#fase_inicio_articulacion', {
    url: '{{ route('articulacion.files.upload', $articulacion->id) }}',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Inicio'
    },
    paramName: 'nombreArchivo'
  });

  Dropzone.on('success', function (res) {
    $('#archivosDeUnaArticulacion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion_inicio();
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

  function datatableArchivosDeUnaArticulacion_inicio() {
  $('#archivosDeUnaArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$articulacion->id, 'Inicio'])}}",
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
      @if ($articulacion->fase->nombre == 'Inicio')
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