@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Proyectos
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="row">
                <div class="col s12 m12 l12 center">
                  @if ($proyecto->fase->nombre == 'Planeación')
                    <a class="btn-large yellow accent-1 m-b-xs black-text" href="{{route('proyecto.notificar.planeacion', $proyecto->id)}}">
                      Pedirle al talento interlocutor que apruebe la fase de planeación.
                    </a>
                  @else
                    <a class="btn-large yellow accent-1 m-b-xs black-text" disabled>
                      Esta fase ya ha sido aprobada por el talento interlocutor.
                    </a>
                  @endif
                </div>
              </div>
              <form method="POST" action="{{route('proyecto.update.planeacion', $proyecto->id)}}">
                {!! method_field('PUT')!!}
                @include('proyectos.gestor.form_planeacion', [
                  'btnText' => 'Modificar'])
                <div class="row">
                  @include('proyectos.archivos_table_fase')
                </div>
                <center>
                  @if ($proyecto->fase->nombre == 'Planeación')
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  @endif
                  <a href="{{ route('proyecto.inicio', $proyecto->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
  datatableArchivosDeUnProyecto_planeacion();
  function changeToPlaneacion() {
    window.location.href = "{{ route('proyecto.planeacion', $proyecto->id) }}";
  }

  function changeToInicio() {
    window.location.href = "{{ route('proyecto.inicio', $proyecto->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('proyecto.ejecucion', $proyecto->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('proyecto.cierre', $proyecto->id) }}";
  }
  var Dropzone = new Dropzone('#fase_planeacion_proyecto', {
    url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Planeación'
    },
    paramName: 'nombreArchivo'
  });

  Dropzone.on('success', function (res) {
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto_planeacion();
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

  function datatableArchivosDeUnProyecto_planeacion() {
  $('#archivosDeUnProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('proyecto.files', [$proyecto->id, 'Planeación'])}}",
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
      @if ($proyecto->fase->nombre == 'Planeación')
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