@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
@php
    $class = 'm12 l12';
@endphp
@canany(['cargar_evidencias', 'edit', 'calificar', 'notificar_comite'], [$comite, $comite->ideas->first()])
    @php
        $class = 'm8 l8';
    @endphp
@endcanany
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('csibt')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Comité de Selección de Ideas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('csibt')}}">CSIBT</a></li>
                            <li class="active">{{$comite->codigo}}</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <br>
                        <center>
                            <span class="card-title center-align">Comité - {{$comite->codigo}} <b>({{$comite->estado->nombre}})</b></span>
                        </center>
                        <div class="divider"></div>
                        <div class="row">
                            @canany(['cargar_evidencias', 'edit', 'calificar', 'notificar_comite'], [$comite, $comite->ideas->first()])
                                <div class="col s12 m4 l4">
                                    <div class="row">
                                        @include('comite.options')
                                    </div>
                                </div>
                            @endcanany
                            <div class="col s12 {{$class}}">
                                @include('comite.detalle_agendamiento')
                            </div>
                        </div>
                        <h5 class="center">Evidencias del comité</h5>
                        <div class="row">
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
                        </div>
                        <div class="divider"></div>
                        <div class="row center">
                            <a href="{{route('csibt')}}" class="waves-effect bg-danger btn center-align">
                                <i class="material-icons left">backspace</i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="modalInfoNotificacionComite" class="modal">
    <div class="modal-content">
      <h4>Notificaciones del comité</h4>
      <p>
          Este apartado te permitirá enviar un correo de notificación con información relacionada con el comité.
          <br>
          ¿Cúal opción debo usar?
          <br>
          A continuación podrá ver el funcionamiento de los diferentes botones para enviar la notificación del comité.
          <ul class="collection">
              <li class="collection-item">
                <a href="javascript:void(0)" class="collection-item">
                    <i class="material-icons left">notifications</i>Enviar citación al talento.
                </a>
                Este botón enviará una notificación únicamente al talento que inscribió la idea de proyecto.
              </li>
              <li class="collection-item">
                <a href="javascript:void(0)" class="collection-item">
                    <i class="material-icons left">notifications</i>Enviar citación a talentos.
                </a>
                Este botón enviará una notificación a todos los talentos.
              </li>
              <li class="collection-item">
                <a href="javascript:void(0)" class="collection-item">
                    <i class="material-icons left">notifications</i>Enviar citación a expertos.
                </a>
                Este botón enviará una notificación a todos los expertos.
              </li>
              <li class="collection-item">
                <a href="javascript:void(0)" class="collection-item">
                    <i class="material-icons left">notifications</i>Enviar citación a todos los participantes.
                </a>
                Este botón enviará una notificación del comité a todos los participantes, tanto expertos como talentos.
              </li>
          </ul>
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok.</a>
    </div>
</div>
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