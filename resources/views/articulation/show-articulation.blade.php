@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{ $articulation->articulationstage->present()->articulationStageCode() }}</a></li>
                    <li ><a href="{{route('articulations.show',  $articulation)}}">{{ $articulation->present()->articulationCode() }}</a></li>
                    <li class="active">{{ __('Articulations') }}</li>
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
                                    <div class="mailbox-view-header">
                                        @include('articulation.options.articulation-options-header')
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                                @include('articulation.articulation-history-change')
                                            </div>
                                            <div class="col s12">
                                                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                                                    <li class="tab col s3"><a href="#startphase" class="active">Inicio</a></li>
                                                    <li class="tab col s3"><a class="" href="#executionphase">Ejecución</a></li>
                                                    <li class="tab col s3"><a href="#closingphase" class="">Cierre</a></li>
                                                </ul>
                                            </div>
                                            <div id="startphase" class="col s12" style="display: block;">
                                                @include('articulation.detail.start-phase-detail')
                                            </div>
                                            <div id="executionphase" class="col s12" style="display: none;">
                                                @include('articulation.detail.execution-phase-detail')
                                            </div>
                                            <div id="closingphase" class="col s12" style="display: none;">
                                                @include('articulation.detail.closing-phase-detail')
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
        datatableArchiveArticulationExecution();
        datatableArchiveArticulationClosing();

        function datatableArchiveArticulationExecution() {
            $('#archivesArticulationsExecution').DataTable({
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
                    "data":{
                        type: "Articulation",
                        phase: "Ejecución"
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
                    }
                ],
            });
        }
        function datatableArchiveArticulationClosing() {
            $('#archivesArticulationsClosing').DataTable({
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
                    "data":{
                        type: "Articulation",
                        phase: "Cierre"
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
                    }
                ],
            });
        }

        function datatableArchiveArticulationStart() {
            $('#archivosArticulacion').DataTable({
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
                    "data":{
                        type: "Articulation",
                        phase: "Inicio"
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
                ],
            });
        }
    </script>
@endpush



