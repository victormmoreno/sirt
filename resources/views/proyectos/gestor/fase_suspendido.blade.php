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
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="row">
                <div class="col s12 m6 l6 offset-s3 offset-m3 offset-l3 center">
                  @if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 0)
                  <a href="{{route('proyecto.notificar.suspension', $proyecto->id)}}">
                    <div class="card-panel yellow accent-1 black-text">
                      Solicitar al dinamizador que apruebe la suspensión del proyecto.
                    </div>
                  </a>
                  @else
                  <a disabled>
                    <div class="card-panel yellow accent-1 black-text">
                      Esta fase ya ha sido aprobada por el dinamizador.
                    </div>
                  </a>
                  @endif
                </div>
              </div>
              <form method="POST" name="frmSuspenderProyectoGestor" action="{{route('proyecto.update.suspendido', $proyecto->id)}}">
                @include('proyectos.gestor.form_suspendido', [
                  'btnText' => 'Modificar'])
                <div class="row">
                  @include('proyectos.archivos_table_fase', ['fase' => 'suspendido'])
                </div>
                <center>
                  @if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 1)
                  <button type="submit" onclick="preguntaSuspender(event)" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Suspender</button>
                  @else
                  <button disabled class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>El dinamizador no ha aprobado la suspensión de este proyecto</button>
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
      datatableArchivosDeUnProyecto_suspendido();
    var Dropzone = new Dropzone('#fase_suspendido_proyecto', {
        url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
        params: {
        fase: 'Suspendido'
        },
        paramName: 'nombreArchivo'
    });

    function preguntaSuspender(e){
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro(a) de suspender este proyecto?',
    text: "No podrás revertir esta acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        document.frmSuspenderProyectoGestor.submit();
      }
    })
  }

  Dropzone.on('success', function (res) {
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto_suspendido();
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

  function datatableArchivosDeUnProyecto_suspendido() {
  $('#archivosDeUnProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('proyecto.files', [$proyecto->id, 'Suspendido'])}}",
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
      @if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 0)
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