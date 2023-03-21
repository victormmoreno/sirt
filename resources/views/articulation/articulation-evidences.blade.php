@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{ $articulation->articulationstage->present()->articulationStageCode() }}</a></li>
                    <li ><a href="{{route('articulations.show',  $articulation)}}">{{ $articulation->present()->articulationCode() }}</a></li>
                    <li class="active">Evidencias</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12 no-p-h">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-options">
                                    <ul>
                                        <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de {{$articulation->present()->articulationPhase()}}</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha Inicio: {{$articulation->present()->articulationStartDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="card server-card card-transparent">
                                                        <div class="card-content">
                                                            <span class="card-title center primary-text m-t-lg">Evidencias</span>
                                                            <div class="row">
                                                                <div class="col s12 m12 l12">
                                                                    <div class="row">
                                                                        <div class="dropzone" id="articulacion_upload_archives"></div>

                                                                    </div>
                                                                    <div class="divider"></div>
                                                                    <table
                                                                        class="display responsive-table datatable-example dataTable"
                                                                        style="width: 100%"
                                                                        id="archivesArticulationsStart">
                                                                        <thead class="bg-primary white-text">
                                                                        <tr>
                                                                            <th>Archivo</th>
                                                                            <th style="width: 10%">Descargar</th>

                                                                            <th style="width: 10%">Eliminar</th>
                                                                        </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        datatableArchiveArticulationStart();
        var Dropzone = new Dropzone('#articulacion_upload_archives', {
            url: '{{ route('articulation.files.upload', [$articulation->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "Articulation",
                phase: '{{isset($articulation->phase) ? $articulation->phase->nombre : "Inicio" }}'
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            $('#archivesArticulationsStart').dataTable().fnDestroy();
            datatableArchiveArticulationStart();
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                type: 'success',
                title: 'El archivo se ha subido con éxito!'
            });
        });

        Dropzone.on('error', function (file, res) {
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
        });

        Dropzone.autoDiscover = false;

        function datatableArchiveArticulationStart() {
            $('#archivesArticulationsStart').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                "lengthChange": false,
                "ajax": {
                    "url": "{{route('articulation.files', [$articulation->id])}}",
                    "type": "get",
                    "data": {
                        type: "Articulation",
                        phase: '{{isset($articulation->phase) ? $articulation->phase->nombre : "Inicio" }}'
                    },
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
            });
        }
    </script>
@endpush


