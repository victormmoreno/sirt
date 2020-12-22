@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('articulacion')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Articulaciones con Grupos de Investigación
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('articulaciones.navegacion_fases')
              <div class="row">
                <div class="col s12 m6 l6 offset-s3 offset-m3 offset-l3 center">
                  @if ($articulacion->fase->nombre == 'Planeación')
                  <a href="{{route('articulacion.notificar.planeacion', $articulacion->id)}}">
                    <div class="card-panel yellow accent-1 black-text">
                      Solicitar al dinamizador que apruebe la fase de planeación.
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
              <form method="POST" action="{{route('articulacion.update.planeacion', $articulacion->id)}}">
                {!! method_field('PUT')!!}
                @include('articulaciones.gestor.form_planeacion', [
                  'btnText' => 'Modificar'])
                <div class="row">
                  @include('articulaciones.archivos_table_fase', ['fase' => 'planeacion'])
                </div>
                <center>
                  @if ($articulacion->fase->nombre == 'Planeación')
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
  datatableArchivosDeUnaArticulacion_planeacion();
  function changeToInicio() {
    window.location.href = "{{ route('articulacion.inicio', $articulacion->id) }}";
  }

  function changeToPlaneacion() {
    window.location.href = "{{ route('articulacion.planeacion', $articulacion->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('articulacion.ejecucion', $articulacion->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('articulacion.cierre', $articulacion->id) }}";
  }


  var Dropzone = new Dropzone('#fase_planeacion_articulacion', {
    url: '{{ route('articulacion.files.upload', $articulacion->id) }}',
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
    $('#archivosDeUnaArticulacion').dataTable().fnDestroy();
    datatableArchivosDeUnaArticulacion_planeacion();
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

  function datatableArchivosDeUnaArticulacion_planeacion() {
  $('#archivosDeUnaArticulacion').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    processing: true,
    serverSide: true,
    order: false,
    ajax:{
      url: "{{route('articulacion.files', [$articulacion->id, 'Planeación'])}}",
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
      @if ($articulacion->fase->nombre == 'Planeación')
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