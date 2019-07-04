@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{route('articulacion')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> CSIBT
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m6 l6">
                    <small>Código de la Articulación</small>
                    <input required disabled value="{{$articulacion->codigo_articulacion}}">
                  </div>
                  <div class="col s12 m6 l6">
                    <small>Fecha de Inicio de la Articulación</small>
                    <input value="{{$articulacion->fecha_inicio->toDateString()}}" disabled>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l6">
                    <small>Estado de la Articulación</small>
                    <input disabled value="{{$articulacion->estado}}">
                  </div>
                  <div class="col s12 m6 l6">
                    <small>Actividad</small>
                    <input value="{{$articulacion->tipoArticulacion}}" disabled>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de Inicio</h5>
                  <div class="col s4 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $articulacion->acta_inicio == 0 ? '' : 'checked' }} id="entregable_acta_inicio" value="1">
                      <label for="entregable_acta_inicio">Acta de Inicio<span class="red-text">*</span></label>
                      {!! $articulacion->tipo_articulacion == 'Grupo de Investigación' ? '<a class="btn btn-floating modal-trigger" href="#modalContenidoActaInicio"><i class="material-icons left">info_outline</i></a>' : '' !!}
                    </p>
                  </div>
                  @if ($articulacion->tipo_articulacion == 'Grupo de Investigación')
                    <div class="col s4 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" disabled {{ $articulacion->acc == 0 ? '' : 'checked' }} id="entregable_acuerdo_confidencialidad_compromiso" value="1">
                        <label for="entregable_acuerdo_confidencialidad_compromiso">Formato de confidencialidad y compromiso firmado <span class="red-text">*</span></label>
                      </p>
                    </div>
                  @endif
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables Fase de {{ $articulacion->tipo_articulacion == 'Grupo de Investigación' ? 'Co-Ejecución' : 'Ejecución' }}</h5>
                  <div class="col s4 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $articulacion->actas_seguimiento == 0 ? '' : 'checked' }} id="entregable_acta_seguimiento" value="1">
                      <label for="entregable_acta_seguimiento">Actas de Seguimiento<span class="red-text">*</span></label>
                    </p>
                  </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Entregables de la Fase de Cierre</h5>
                  <div class="col s4 m4 l4">
                    <p class="p-v-xs">
                      <input type="checkbox" disabled {{ $articulacion->acta_cierre == 0 ? '' : 'checked' }} id="entregable_acta_cierre" value="1">
                      <label for="entregable_acta_cierre">Acta de Cierre<span class="red-text">*</span></label>
                    </p>
                  </div>
                  @if ($articulacion->tipo_articulacion == 'Empresa' || $articulacion->tipo_articulacion == 'Emrpendedor')
                    <div class="col s4 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" disabled {{ $articulacion->informe_final == 0 ? '' : 'checked' }} id="entregable_informe_final" value="1">
                        <label for="entregable_informe_final">Informe Final de la Asesoría<span class="red-text">*</span></label>
                      </p>
                    </div>
                    <div class="col s4 m4 l4">
                      <p class="p-v-xs">
                        <input type="checkbox" disabled {{ $articulacion->pantallazo == 0 ? '' : 'checked' }} id="entregable_encuesta_satisfaccion" value="1">
                        <label for="entregable_encuesta_satisfaccion">Encuesta de Satisfacción (Pantallazo)<span class="red-text">*</span></label>
                      </p>
                    </div>
                  @endif
                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Otros Entregables</h5>

                </div>
                <div class="divider"></div>
                <div class="row">
                  <h5>Revisado Final</h5>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado" disabled value="0" id="txtrevisadoa" {{ $articulacion->revisado_final == 'Por Evaluar' ? 'checked' : '' }} type="radio">
                      <label for="txtrevisadoa">Por evaluar</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado" disabled value="1" id="txtrevisadob" {{ $articulacion->revisado_final == 'Aprobado' ? 'checked' : '' }} type="radio">
                      <label for="txtrevisadob">Aprobado</label>
                    </p>
                  </div>
                  <div class="col s12 m4 l4">
                    <p class="p-v-xs">
                      <input name="txtrevisado" disabled value="2" id="txtrevisadoc" {{ $articulacion->revisado_final == 'No Aprobado' ? 'checked' : '' }} type="radio">
                      <label for="txtrevisadoc">No aprobado</label>
                    </p>
                  </div>
                </div>
                <center>
                  <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <ul class="collapsible" data-collapsible="accordion">
                      <li>
                        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para ver los entregables de la articulación</div>
                        <div class="collapsible-body">
                          <div class="row">
                            <div class="col s12 m12 l12">
                              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivoDeUnaArticulacion">
                                <thead>
                                  <tr>
                                    <th>Archivo</th>
                                    <th>Fase</th>
                                    <th style="width: 10%">Descargar</th>
                                    {{-- <th style="width: 10%">Eliminar</th> --}}
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div id="modalContenidoActaInicio" class="modal">
    <div class="modal-content">
      <h4>El acta de inicio debe llevar</h4>
      <ul class="collection">
        <li class="collection-item">Párrafo donde se definan los productos de la articulación.</li>
        <li class="collection-item">Debe incluir la firma del líder del grupo de investigación.</li>
        <li class="collection-item">Pantallazo del GrupLac de Colciencias donde se evidencie la institución que avala el grupo y la categoría a la fecha.</li>
        <li class="collection-item">Para grupos de investigación SENA: Incluir el código de registro en SGPS de los proyectos con recursos aprobados.</li>
      </ul>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
    </div>
  </div>
@endsection
@push('script')
  <script>
    datatableArchivosDeUnaArticulacion();
    function datatableArchivosDeUnaArticulacion() {
      $('#archivoDeUnaArticulacion').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: false,
        ajax:{
          url: "/articulacion/archivosDeUnaArticulacion/"+{{$articulacion->id}},
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
