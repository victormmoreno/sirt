@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('meta-content', 'Charlas Informativas')
@section('meta-keywords', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
            <h5 class="left left-align primary-text">
                  <a href="{{route('charla')}}">
                      <i class="material-icons arrow-l left primary-text">
                          arrow_back
                      </i>
                  </a>
                Charlas Informativas
            </h5>
            <div class="right show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('charla')}}">Charlas Informativas</a></li>
                    <li class="active">Evidencias</li>
                </ol>
            </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form onsubmit="return checkSubmit()" method="post" action="{{ route('charla.update.evidencias', $charla->id) }}">
                  {!! method_field('PUT')!!}
                  {!! csrf_field() !!}
                  @include('charlas.form_evidencias')
                  <div class="center">
                    <button type="submit" class="bg-secondary btn center-aling"><i class="material-icons right">send</i>Modificar</button>
                    <a href="{{route('charla')}}" class="bg-danger btn center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
                  </div>
                </form>
              </div>
            </div>
            @include('charlas.table_evidencias')
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
  datatableArchivosDeUnaCharlaInformatva();
  function datatableArchivosDeUnaCharlaInformatva() {
    $('#archivosDeUnaCharlaInformartiva').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "{{route('charla.files', $charla->id)}}",
        type: "get",
      },
      columns: [
      { data: 'file', name: 'file', orderable: false },
      { data: 'download', name: 'download', orderable: false },
      { data: 'delete', name: 'delete', orderable: false }
      ],
    });
  }

  var DropzoneCharla = new Dropzone('#evidencias_charlaInformartiva', {
    url: "{{route('charla.files.upload', $charla->id)}}",
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
    paramName: 'nombreArchivo'
  });

  DropzoneCharla.on('success', function (res) {
    $('#archivosDeUnaCharlaInformartiva').dataTable().fnDestroy();
    datatableArchivosDeUnaCharlaInformatva();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      icon: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneCharla.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      icon: 'error',
      title: 'El archivo no se ha podido subir!'
    });
  })
  Dropzone.autoDiscover = false;

  </script>
@endpush
