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
                      <input type="checkbox" disabled name="ev_correos" {{ $comite->correos == 0 ? '' : 'checked' }} id="ev_correos" value="1">
                      <label for="ev_correos">Correos<span class="red-text">*</span></label>
                    </p>
                  </div>
                  <div class="col s6 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled name="ev_listado" {{ $comite->listado_asistencia == 0 ? '' : 'checked' }} id="ev_listado" value="1">
                      <label for="ev_listado">Listado de Asistencia <span class="red-text">*</span></label>
                    </p>
                  </div>
                  <div class="col s6 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled name="ev_otros" {{ $comite->otros == 0 ? '' : 'checked' }} id="ev_otros" value="1">
                      <label for="ev_otros">Otros</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDelComiteDinamizadorGestorAdministador">
                  <thead>
                    <tr>
                      <th>Archivo</th>
                      <th style="width: 10%">Descargar</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                <div class="divider"></div>
                <center>
                  <a href="{{route('csibt')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Volver</a>
                </center>
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
      $('#archivosDelComiteDinamizadorGestorAdministador').DataTable({
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
          orderable: false,
        },
        {
          data: 'download',
          name: 'download',
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
  </script>
@endpush
