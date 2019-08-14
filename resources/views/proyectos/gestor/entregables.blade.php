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
                  <div class="input-field col s12 m6 l6">
                    <input name="txtcodigo_proyecto" disabled value="{{ $proyecto->codigo_proyecto }}" id="txtcodigo_proyecto">
                    <label class="active" for="txtcodigo_proyecto">Código de Proyecto</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input name="txtnombre" value="{{ $proyecto->nombre }}" disabled id="txtnombre" required >
                    <label class="active" for="txtnombre">Nombre del Proyecto</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <input name="txtgestor_id" value="{{ $proyecto->nombre_gestor }}" disabled id="txtgestor_id">
                    <label class="active" for="txtgestor_id">Gestor</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input name="txtlinea" id="txtlinea" value="{{ $proyecto->nombre_linea }}" disabled>
                    <label class="active" for="txtlinea">Línea Tecnológica</label>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase Inicio</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtacc', $entregables->acc == 'Si') ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
                      <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtmanual_uso_inf', $entregables->manual_uso_inf == 'Si') ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
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
                      <input type="checkbox" {{ old('txtacta_inicio', $entregables->acta_inicio == 'Si') ? 'checked' : ''}} id="txtacta_inicio" name="txtacta_inicio" value="1">
                      <label for="txtacta_inicio">Acta de Inicio.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtestado_arte', $entregables->estado_arte == 'Si') ? 'checked' : ''}} id="txtestado_arte" name="txtestado_arte" value="1">
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
                      <input type="checkbox" {{ old('txtactas_seguimiento', $entregables->actas_seguimiento == 'Si') ? 'checked' : '' }} id="txtactas_seguimiento" name="txtactas_seguimiento" value="1">
                      <label for="txtactas_seguimiento">Actas de Seguimiento.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtvideo_tutorial', $entregables->video_tutorial == 'Si') ? 'checked' : '' }} id="txtvideo_tutorial" name="txtvideo_tutorial" value="1" onclick="mostrarInputUrlVideo()">
                      <label for="txtvideo_tutorial">Video Tutorial.</label>
                    </p>
                  </div>
                </div>
                <div class="row" id="divUrlVideoTutorial">
                  <div class="input-field col s12 m12 l12">
                    <input type="text" name="txturl_videotutorial" id="txturl_videotutorial" value="{{ old('txturl_videotutorial', $entregables->url_videotutorial) }}">
                    <label for="txturl_videotutorial">Url del Video Turorial <span class="red-text">*</span></label>
                    @error('txturl_videotutorial')
                      <label id="txturl_videotutorial-error" class="error" for="txturl_videotutorial">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
                {{-- Inicio para subir entregables en la fase de ejecucion --}}
                <div class="row">
                  <ul class="collapsible" data-collapsible="accordion">
                    <li>
                      <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Ejecución.</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="center col s12 m12 l12">
                            <h6>Pulse aquí para subir los entregables de la fase de Ejecución.</h6>
                            <div class="dropzone" id="fase_ejecucion_proyecto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                {{-- Fin para subir entregables en la fase de ejecucion --}}
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Cierre</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtficha_caracterizacion', $entregables->ficha_caracterizacion == 'Si') ? 'checked' : '' }} id="txtficha_caracterizacion" name="txtficha_caracterizacion" value="1">
                      <label for="txtficha_caracterizacion">Ficha de caracterización del prototipo.</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtacta_cierre', $entregables->acta_cierre == 'Si') ? 'checked' : '' }} id="txtacta_cierre" name="txtacta_cierre" value="1">
                      <label for="txtacta_cierre">Acta de Cierre.</label>
                      <a class="btn btn-floating modal-trigger" href="#modalContenidoActaCierre_Proyecto"><i class="material-icons left">info_outline</i></a>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" {{ old('txtencuesta', $entregables->encuesta == 'Si') ? 'checked' : '' }} id="txtencuesta" name="txtencuesta" value="1">
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
                <div class="divider"></div>
                <center>
                  <button class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
              </form>
              @include('proyectos.archivos_table')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<div id="modalContenidoActaCierre_Proyecto" class="modal">
  <div class="modal-content">
    <h4>Información sobre el acta de cierre</h4>
    <ul class="collection">
      <li class="collection-item">El acto de cierre debe tener las <b>Lecciones Aprendidas</b>.</li>
      <li class="collection-item">En caso de que el proyecto se vaya a suspender, el acta de cierre deberá ser el acta de suspensión de proyecto.</li>
    </ul>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
  </div>
</div>
@endsection
@push('script')
  <script>
  datatableArchivosDeUnProyecto();
  var divUrlVideoTutorial = $('#divUrlVideoTutorial');
  divUrlVideoTutorial.hide();

  @if($errors->any())
  divUrlVideoTutorial.show();
  @endif
  function datatableArchivosDeUnProyecto() {
    $('#archivosDeUnProyecto').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "{{route('proyecto.files', $proyecto->id)}}",
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

  /**
  * Oculta o muestra el campo de la url del video dependiendo del checkbox del Video Tutorial
  */
  function mostrarInputUrlVideo() {
    if ( $('#txtvideo_tutorial').is(':checked') ) {
      divUrlVideoTutorial.show();
    } else {
      divUrlVideoTutorial.hide();
    }
  }

  var DropzoneProyectoCierre = new Dropzone('#fase_cierre_proyecto', {
    url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
    uploadMultiple: false,
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

  var DropzoneProyectoPlaneacion = new Dropzone('#fase_planeacion_proyecto', {
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

  var DropzoneProyectoInicio = new Dropzone('#fase_inicio_proyecto', {
    url: '{{ route('proyecto.files.upload', $proyecto->id) }}',
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
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto();
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
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto();
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
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto();
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
    $('#archivosDeUnProyecto').dataTable().fnDestroy();
    datatableArchivosDeUnProyecto();
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
