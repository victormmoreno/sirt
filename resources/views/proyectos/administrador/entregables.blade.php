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
                      <input type="checkbox" disabled {{ $entregables->acc == 'Si' ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
                      <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->manual_uso_inf == 'Si' ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
                      <label for="txtmanual_uso_inf">Manual de uso de Infraestructura.</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase Planeación</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->acta_inicio == 'Si' ? 'checked' : ''}} id="txtacta_inicio" name="txtacta_inicio" value="1">
                      <label for="txtacta_inicio">Acta de Inicio.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->estado_arte == 'Si' ? 'checked' : ''}} id="txtestado_arte" name="txtestado_arte" value="1">
                      <label for="txtestado_arte">Estado del Arte.</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Ejecución</h5>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->actas_seguimiento == 'Si' ? 'checked' : '' }} id="txtactas_seguimiento" name="txtactas_seguimiento" value="1">
                      <label for="txtactas_seguimiento">Actas de Seguimiento.</label>
                    </p>
                  </div>
                  <div class="col s6 m6 l6">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->video_tutorial == 'Si' ? 'checked' : '' }} id="txtvideo_tutorial" name="txtvideo_tutorial" value="1">
                      <label for="txtvideo_tutorial">Video Tutorial.</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Cierre</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->ficha_caracterizacion == 'Si' ? 'checked' : '' }} id="txtficha_caracterizacion" name="txtficha_caracterizacion" value="1">
                      <label for="txtficha_caracterizacion">Ficha de caracterización del prototipo.</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->acta_cierre == 'Si' ? 'checked' : '' }} id="txtacta_cierre" name="txtacta_cierre" value="1">
                      <label for="txtacta_cierre">Acta de Cierre.</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $entregables->encuesta == 'Si' ? 'checked' : '' }} id="txtencuesta" name="txtencuesta" value="1">
                      <label for="txtencuesta">Encuesta de Satisfacción del Servicio.</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Revisado Final</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado_final" {{ $proyecto->revisado_final == 'Por Evaluar' ? 'checked' : ''}} disabled type="radio" id="txtrevisadoa" value="0">
                      <label for="txtrevisadoa">Por evaluar</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado_final" {{ $proyecto->revisado_final == 'Aprobado' ? 'checked' : '' }} disabled type="radio" id="txtrevisadob" value="1">
                      <label for="txtrevisadob">Aprobado</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado_final" {{ $proyecto->revisado_final == 'No Aprobado' ? 'checked' : ''}} disabled type="radio" id="txtrevisadoc" value="2">
                      <label for="txtrevisadoc">No aprobado</label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <center>
                  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
                @include('proyectos.archivos_table')
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
    datatableArchivosDeUnProyecto();
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
        ],
        // initComplete: function () {
          //   this.api().columns().every(function () {
            //     var column = this;
            //     var input = document.createElement("input");
            //     $(input).appendTo($(column.footer()).empty())
            //     .on('change', function () {
              //       column.search($(this).val(), false, false, true).draw();
              //     });
              //   });
              // }
            });
          }
        </script>
      @endpush
