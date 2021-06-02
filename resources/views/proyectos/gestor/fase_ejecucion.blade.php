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
                  @if ($proyecto->fase->nombre == 'Ejecución')
                    @if ( ($ultimo_movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsReversar())
                     || ($ultimo_movimiento->rol == App\User::IsDinamizador() && $ultimo_movimiento->movimiento == App\Models\Movimiento::IsAprobar()) )
                      <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, 'Ejecución'])}}">
                        <div class="card-panel yellow accent-1 black-text">
                          Solicitar al talento que apruebe la fase de ejecución.
                        </div>
                      </a>
                    @else
                      @if ($ultimo_movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                      <a disabled>
                        <div class="card-panel yellow accent-1 black-text">
                          Se envió la solicitud de aprobación al talento interlocutor.
                        </div>
                      </a>
                      @endif
                      @if($ultimo_movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->rol == App\User::IsTalento())
                        <a disabled>
                          <div class="card-panel yellow accent-1 black-text">
                            El talento interlocutor aprobó la fase de ejecución, aún falta la aprobación del dinamizador.
                          </div>
                        </a>
                      @endif
                    @endif
                  @else
                    <a disabled>
                      <div class="card-panel yellow accent-1 black-text">
                        Este proyecto no se encuentra en fase de ejecución.
                      </div>
                    </a>
                  @endif
                </div>
              </div>
              <form method="POST" action="{{route('proyecto.update.ejecucion', $proyecto->id)}}">
                {!! method_field('PUT')!!}
                @include('proyectos.gestor.form_ejecucion', [
                  'btnText' => 'Modificar'])
                <div class="row">
                  @include('proyectos.archivos_table_fase', ['fase' => 'ejecucion'])
                </div>
                <center>
                  @if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 0)
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  @endif
                  <a href="{{ route('proyecto.planeacion', $proyecto->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
  datatableArchivosDeUnProyecto_ejecucion();
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
  var Dropzone = new Dropzone('#fase_ejecucion_proyecto', {
    url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Ejecución'
    },
    paramName: 'nombreArchivo'
  });

  Dropzone.on('success', function (res) {
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto_ejecucion();
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

  function datatableArchivosDeUnProyecto_ejecucion() {
  $('#archivosDeUnProyecto').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('proyecto.files', [$proyecto->id, 'Ejecución'])}}",
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
      @if ($proyecto->fase->nombre == 'Ejecución')
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