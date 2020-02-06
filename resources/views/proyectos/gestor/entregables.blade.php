@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <h5>
        <a class="footer-text left-align" href="{{ route('proyecto') }}">
          <i class="left material-icons">arrow_back</i>
        </a> Proyectos
      </h5>
      <div class="card">
        <div class="card-content">
          <div class="row">
            <h5>Entregables de la fase de inicio.</h5>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
              <form action="{{route('proyecto.update.entregables.inicio', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
                @include('proyectos.form_entregables_inicio')
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  <a href="{{ route('proyecto.fase.inicio', $proyecto->id) }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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

  @if ($entregables->video_tutorial == 'Si')
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
      // $('button[type="submit"]').attr('disabled', 'disabled');
    } else {
      divUrlVideoTutorial.hide();
      // $('button[type="submit"]').removeAttr('disabled');
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
