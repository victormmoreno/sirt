@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
    <main class="mn-inner">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="left left-align">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                        <li ><a href="{{route('articulation-stage.show',  $articulationStage)}}">{{ $articulationStage->present()->articulationStageCode() }}</a></li>
                        <li class="active">{{ __('Details') }}</li>
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
                                            <li class="text-mailbox ">La {{__('articulation-stage')}} se encuentra
                                                actualmente {{$articulationStage->present()->articulationStageStatus()}}</li>
                                            <div class="right">
                                                <li class="text-mailbox">Fecha
                                                    registro: {{$articulationStage->present()->articulationStageCreatedDate()}}</li>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="mailbox-view no-s">
                                        @include('articulation.options.articulation-stages-options-header')
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <div class="row">
                                                <div class="mailbox-text">
                                                    <div class="row">
                                                        <div class="card server-card card-transparent">
                                                            <div class="card-content">
                                                                <span class="card-title center orange-text m-t-lg">Evidencias</span>

                                                                <div class="stats-info">
                                                                    <ul>
                                                                        <li> Acta de inicio
                                                                            <div class="percent-info orange-text left">
                                                                                <i class="material-icons">check</i>
                                                                            </div>
                                                                        </li>
                                                                        <li>Acta de cierre
                                                                            <div class="percent-info orange-text left">
                                                                                <i class="material-icons">check</i>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col s12 m12 l12">
                                                                        <div class="row">
                                                                            <div class="dropzone"
                                                                                 id="fase_inicio_articulacion"></div>

                                                                        </div>
                                                                        <div class="divider"></div>
                                                                        <table
                                                                            class="display responsive-table datatable-example dataTable"
                                                                            style="width: 100%"
                                                                            id="archivosArticulacion">
                                                                            <thead>
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
    </main>
@endsection
@push('script')
    <script>
        datatableArchiveArticulationStage();

        var Dropzone = new Dropzone('#fase_inicio_articulacion', {
            url: '{{ route('articulation.files.upload', [$articulationStage->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "{{ basename(\App\Models\ArticulationStage::class)}}"
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            $('#archivosArticulacion').dataTable().fnDestroy();
            datatableArchiveArticulationStage();
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

        function datatableArchiveArticulationStage() {
            $('#archivosArticulacion').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,

                "ajax": {
                    "url": "{{route('articulation.files', [$articulationStage->id])}}",
                    "type": "get",
                    "data":{
                        type: "{{ basename(\App\Models\ArticulationStage::class)}}"
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


