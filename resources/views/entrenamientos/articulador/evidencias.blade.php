@extends('layouts.app')
@section('meta-title', 'Taller de fortalecimiento')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5>
                    <a class="footer-text left-align" href="{{route('entrenamientos')}}">
                      <i class="left material-icons">arrow_back</i>
                    </a> Talleres de fortalecimiento
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('entrenamientos')}}">Talleres de fortalecimiento</a></li>
                      <li class="active">Evidencias</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form onsubmit="return checkSubmit()" method="post" action="{{ route('entrenamientos.update.evidencias', $entrenamiento->id) }}">
                    @include('entrenamientos.articulador.form_evidencias')
                    <div class="divider"></div>
                    <center>
                        <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                        <a href="{{route('entrenamientos')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                    </center>
                </form>
                @include('entrenamientos.tabla_evidencias')
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
  datatableArchivosDeUnEntrenamiento();
  function datatableArchivosDeUnEntrenamiento() {
    $('#archivosDeUnEntrenamiento').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: host_url + "/entrenamientos/datatableArchivosDeUnEntrenamiento/"+{{$entrenamiento->id}},
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

  var DropzoneEntrenamiento = new Dropzone('#evidencias_entrenamiento', {
    url: host_url + '/entrenamientos/store/' + {{$entrenamiento->id}} + '/files',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    params: {
      fase: 'Inscrito'
    },
    paramName: 'nombreArchivo'
  });

  DropzoneEntrenamiento.on('success', function (res) {
    $('#archivosDeUnEntrenamiento').dataTable().fnDestroy();
    datatableArchivosDeUnEntrenamiento();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneEntrenamiento.on('error', function (file, res) {
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
