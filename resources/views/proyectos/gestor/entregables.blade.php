@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('proyecto') }}">
          <i class="material-icons arrow-l">arrow_back</i>
        </a> Proyectos
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('proyecto.update.entregables', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                {!! method_field('PUT')!!}
                {!! csrf_field() !!}
                <div class="row">
                  <div class="col s12 m6 l6">
                    <input name="txtcodigo_proyecto" disabled value="{{ $proyecto->codigo_proyecto }}" id="txtcodigo_proyecto">
                    <label for="txtcodigo_proyecto">Código de Proyecto</label>
                  </div>
                  <div class="col s12 m6 l6">
                    <input name="txtnombre" value="{{ $proyecto->nombre }}" disabled id="txtnombre" required >
                    <label for="txtnombre">Nombre del Proyecto</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l6">
                    <input name="txtgestor_id" value="{{ $proyecto->nombre_gestor }}" disabled id="txtgestor_id">
                    <label for="txtgestor_id">Gestor</label>
                  </div>
                  <div class="col s12 m6 l6">
                    <input name="txtlinea" id="txtlinea" value="{{ $proyecto->nombre_linea }}" disabled>
                    <label for="txtlinea">Línea Tecnológica</label>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase Inicio</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->acc == 'Si' ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
                      <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->manual_uso_inf == 'Si' ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
                      <label for="txtmanual_uso_inf">Manual de uso de Infraestructura.</label>
                    </p>
                  </div>
                </div>
                {{-- Inicio para subir entregables en la fase de inicio --}}
                <div class="row">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Inicio.</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="center col s12 m12 l12">
                            <h6>Pulse aquí para subir los entregables de la fase de Inicio.</h6>
                            <div class="dropzone" id="fase_inicio_proyecto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                {{-- Fin para subir entregables en la fase de inicio --}}
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase Planeación</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->acta_inicio == 'Si' ? 'checked' : ''}} id="txtacta_inicio" name="txtacta_inicio" value="1">
                      <label for="txtacta_inicio">Acta de Inicio.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->estado_arte == 'Si' ? 'checked' : ''}} id="txtestado_arte" name="txtestado_arte" value="1">
                      <label for="txtestado_arte">Estado del Arte.</label>
                    </p>
                  </div>
                </div>
                {{-- Inicio para subir entregables en la fase de planeacion --}}
                <div class="row">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Planeación.</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="center col s12 m12 l12">
                            <h6>Pulse aquí para subir los entregables de la fase de Planeación.</h6>
                            <div class="dropzone" id="fase_planeacion_proyecto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                {{-- Fin para subir entregables en la fase de planeacion --}}
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Ejecución</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->actas_seguimiento == 'Si' ? 'checked' : '' }} id="txtactas_seguimiento" name="txtactas_seguimiento" value="1">
                      <label for="txtactas_seguimiento">Actas de Seguimiento.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->video_tutorial == 'Si' ? 'checked' : '' }} id="txtvideo_tutorial" name="txtvideo_tutorial" value="1">
                      <label for="txtvideo_tutorial">Video Tutorial.</label>
                    </p>
                  </div>
                </div>
                {{-- Inicio para subir entregables en la fase de planeacion --}}
                <div class="row">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Planeación.</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="center col s12 m12 l12">
                            <h6>Pulse aquí para subir los entregables de la fase de Planeación.</h6>
                            <div class="dropzone" id="fase_ejecucion_proyecto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                {{-- Fin para subir entregables en la fase de planeacion --}}
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Cierre</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->ficha_caracterizacion == 'Si' ? 'checked' : '' }} id="txtficha_caracterizacion" name="txtficha_caracterizacion" value="1">
                      <label for="txtficha_caracterizacion">Ficha de caracterización del prototipo.</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->acta_cierre == 'Si' ? 'checked' : '' }} id="txtacta_cierre" name="txtacta_cierre" value="1">
                      <label for="txtacta_cierre">Acta de Cierre.</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ $entregables->encuesta == 'Si' ? 'checked' : '' }} id="txtencuesta" name="txtencuesta" value="1">
                      <label for="txtencuesta">Encuesta de Satisfacción del Servicio.</label>
                    </p>
                  </div>
                </div>
                {{-- Inicio para subir entregables en la fase de cierre --}}
                <div class="row">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Cierre.</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="center col s12 m12 l12">
                            <h6>Pulse aquí para subir los entregables de la fase de Cierre.</h6>
                            <div class="dropzone" id="fase_cierre_proyecto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                {{-- Fin para subir entregables en la fase de cierre --}}
                <div class="divider"></div>
                <div class="row">
                  <h5>Revisado Final</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input disabled name="txtrevisado" {{ $proyecto->revisado_final == 'Por Evaluar' ? 'checked' : ''}} type="radio" id="txtrevisadoa">
                      <label for="txtrevisadoa">Por evaluar</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input disabled name="txtrevisado" {{ $proyecto->revisado_final == 'Aprobado' ? 'checked' : '' }} type="radio" id="txtrevisadob">
                      <label for="txtrevisadob">Aprobado</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input disabled name="txtrevisado" {{ $proyecto->revisado_final == 'No Aprobado' ? 'checked' : ''}} type="radio" id="txtrevisadoc">
                      <label for="txtrevisadoc">No aprobado</label>
                    </p>
                  </div>
                </div>
                <center>
                  <button class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
  var DropzoneProyectoCierre = new Dropzone('#fase_cierre_proyecto', {
    url: '/proyecto/store/{{ $proyecto->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Cierre'
    },
    paramName: 'nombreArchivo'
  });

  var DropzoneProyectoEjecucion = new Dropzone('#fase_ejecucion_proyecto', {
    url: '/articulacion/store/{{ $proyecto->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Ejecución'
    },
    paramName: 'nombreArchivo'
  });

  var DropzoneProyectoPlaneacion = new Dropzone('#fase_planeacion_proyecto', {
    url: '/articulacion/store/{{ $proyecto->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Ejecución'
    },
    paramName: 'nombreArchivo'
  });

  var DropzoneProyectoInicio = new Dropzone('#fase_inicio_proyecto', {
    url: '/articulacion/store/{{ $proyecto->id }}/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Inicio'
    },
    paramName: 'nombreArchivo'
  });

  DropzoneProyectoInicio.on('success', function (res) {
    // $('#archivoDeUnaArticulacion').dataTable().fnDestroy();
    // datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneProyectoEjecucion.on('success', function (res) {
    // $('#archivoDeUnaArticulacion').dataTable().fnDestroy();
    // datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneProyectoPlaneacion.on('success', function (res) {
    // $('#archivoDeUnaArticulacion').dataTable().fnDestroy();
    // datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneProyectoCierre.on('success', function (res) {
    // $('#archivoDeUnaArticulacion').dataTable().fnDestroy();
    // datatableArchivosDeUnaArticulacion();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneProyectoInicio.on('error', function (file, res) {
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

  DropzoneProyectoPlaneacion.on('error', function (file, res) {
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

  DropzoneProyectoEjecucion.on('error', function (file, res) {
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

  DropzoneProyectoCierre.on('error', function (file, res) {
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
