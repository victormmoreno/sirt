@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{route('csibt')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> CSIBT
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form id="formValidate">
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
                    <div class="col s12 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_correos" id="ev_correos" value="1">
                        <label for="ev_correos">Correos<span class="red-text">*</span></label>
                      </p>
                    </div>
                    <div class="col s6 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_listado" id="ev_listado" value="1">
                        <label for="ev_listado">Listado de Asistencia <span class="red-text">*</span></label>
                      </p>
                    </div>
                    <div class="col s6 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" name="ev_otros" id="ev_otros" value="1">
                        <label for="ev_otros">Otros</label>
                      </p>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="dropzone"></div>
                  <div class="divider"></div>
                  <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDelComite">
                    <thead>
                      <tr>
                        <th>Archivo</th>
                        <th>Ver</th>
                        <th>Descargar</th>
                        <th>Eliminar</th>
                        {{-- <th>Observaciones</th>
                        <th>Ideas de Proyecto</th>
                        <th>Editar</th>
                        <th>Evidencias</th> --}}
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                    <a href="{{route('csibt')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
        url: "/csibt/archivosDeUnComite/"+{{$comite->id}},
        type: "get",
      },
      columns: [
        {
          data: 'file',
          name: 'file',
        },
        {
          data: 'see',
          name: 'see',
        },
        {
          data: 'download',
          name: 'download',
        },
        {
          data: 'delete',
          name: 'delete',
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
    url: '/csibt/store/{{ $comite->id }}/filesComite',
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
