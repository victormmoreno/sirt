@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('articulacion')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Articulaciones con Grupos de Investigación
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
                <div class="col s12">
                  <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#inicio">Inicio</a></li>
                    <li class="tab col s3"><a href="#planeacion">Planeación</a></li>
                    <li class="tab col s3"><a href="#ejecucion">Ejecución</a></li>
                    <li class="tab col s3"><a href="#cierre">Cierre</a></li>
                  </ul>
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                    @include('articulaciones.historial_cambios')
                </div>
                <div id="inicio" class="col s12 m12 l12">
                    @include('articulaciones.detalle_fase_inicio')
                </div>
                <div id="planeacion" class="col s12 m12 l12">
                    @include('articulaciones.detalle_fase_planeacion')
                </div>
                <div id="ejecucion" class="col s12 m12 l12">
                    @include('articulaciones.detalle_fase_ejecucion')
                </div>
                <div id="cierre" class="col s12 m12 l12">
                    @include('articulaciones.detalle_fase_cierre')
                </div>
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
    datatableArchivosDeUnaArticulacion_inicio();
    datatableArchivosDeUnaArticulacion_planeacion();
    datatableArchivosDeUnaArticulacion_ejecucion();
    datatableArchivosDeUnaArticulacion_cierre();
    function datatableArchivosDeUnaArticulacion_inicio() {
        $('.inicio').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id, 'Inicio'])}}",
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
        });
    }
    function datatableArchivosDeUnaArticulacion_planeacion() {
        $('.planeacion').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id, 'Planeación'])}}",
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
        });
    }
    function datatableArchivosDeUnaArticulacion_ejecucion() {
        $('.ejecucion').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id, 'Ejecución'])}}",
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
        });
    }
    function datatableArchivosDeUnaArticulacion_cierre() {
        $('.cierre').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
            url: "{{route('articulacion.files', [$articulacion->id, 'Cierre'])}}",
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
        });
    }

    </script>
@endpush