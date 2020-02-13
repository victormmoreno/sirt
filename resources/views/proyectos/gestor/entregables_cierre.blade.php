@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('proyecto.inicio', $proyecto->id) }}">
          <i class="left material-icons">arrow_back</i>
        </a> Proyectos de Desarrollo Tecnológico
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <h5 class="center">Entregables de la fase de cierre.</h5>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('proyecto.update.entregables.cierre', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('proyectos.gestor.form_entregables_cierre')
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
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
  var Dropzone = new Dropzone('#fase_cierre_proyecto', {
    url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
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
    $('#archivosDeUnProyecto_FaseInicio').dataTable().fnDestroy();
    // datatableArchivosDeUnProyecto();
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
</script>
@endpush
