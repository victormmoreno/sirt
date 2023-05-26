@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
            <div class="col s8 m8 l10">
                <h5 class="left-align">
                      <a class="footer-text left-align" href="{{route('csibt')}}">
                          <i class="material-icons arrow-l">
                              arrow_back
                          </i>
                      </a>
                    CSIBT
                </h5>
            </div>
            <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('csibt')}}">CSIBT</a></li>
                    <li class="active">Evidencias</li>
                </ol>
            </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form id="formValidate" onsubmit="return checkSubmit()" method="post" action="{{ route('csibt.update.evidencias', $comite->id) }}">
                  {!! method_field('PUT')!!}
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="col s12 m6 l6">
                      <small>Código del Comité <span class="red-text">*</span></small>
                      <input required disabled value="{{$comite->codigo}}">
                    </div>
                    <div class="col s12 m4 l4">
                      <small>Fecha del Comité <span class="red-text">*</span></small>
                      <input value="{{$comite->fechacomite->toDateString()}}" disabled required >
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <h5>Evidencias del CSIBT</h5>
                    <div class="col s12 m3 l3">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_acta" {{ $comite->acta == 0 ? '' : 'checked' }} id="ev_acta" value="1">
                        <label for="ev_acta">Acta de comité</label>
                      </p>
                    </div>
                    <div class="col s12 m3 l3">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_formato" {{ $comite->formato_evaluacion == 0 ? '' : 'checked' }} id="ev_formato" value="1">
                        <label for="ev_formato">Formato de evaluación</label>
                      </p>
                    </div>
                    <div class="col s6 m3 l3">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_listado" {{ $comite->listado_asistencia == 0 ? '' : 'checked' }} id="ev_listado" value="1">
                        <label for="ev_listado">Listado de Asistencia</label>
                      </p>
                    </div>
                    <div class="col s6 m3 l3">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_otros" {{ $comite->otros == 0 ? '' : 'checked' }} id="ev_otros" value="1">
                        <label for="ev_otros">Otros</label>
                      </p>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="dropzone"></div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect waves-light btn bg-secondary center-align"><i class="material-icons right">send</i>Modificar</button>
                    <a href="{{route('csibt.detalle', $comite)}}" class="waves-effect bg-danger btn center-align"><i class="material-icons left">backspace</i>Cancelar</a>
                  </center>
                </form>
                <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDelComite">
                  <thead>
                    <tr>
                      <th>Archivo</th>
                      <th style="width: 10%">Descargar</th>
                      <th style="width: 10%">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
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
  datatableArchivoDeUnComite();
  function datatableArchivoDeUnComite() {
    $('#archivosDelComite').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: host_url + "/csibt/archivosDeUnComite/"+{{$comite->id}},
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

  var DropzoneComite = new Dropzone('.dropzone', {
    url: host_url + '/csibt/store/{{ $comite->id }}/filesComite',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
    paramName: 'nombreArchivo'
  });

  DropzoneComite.on('success', function (res) {
    $('#archivosDelComite').dataTable().fnDestroy();
    datatableArchivoDeUnComite();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      type: 'success',
      title: 'El archivo se ha subido con éxito!'
    });
  })

  DropzoneComite.on('error', function (file, res) {
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
