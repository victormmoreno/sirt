@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage / articulation')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li><a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{
                            $articulation->articulationstage->present()->articulationStageCode() }}</a></li>
                    <li><a href="{{route('articulations.show',  $articulation)}}">{{
                            $articulation->present()->articulationCode() }}</a></li>
                    <li class="active">{{ __('Articulation') }}</li>
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
                                        <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de
                                            {{$articulation->present()->articulationPhase()}}</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha Inicio:
                                                {{$articulation->present()->articulationStartDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <div class="left">
                                                    <span
                                                        class="mailbox-title">{{$articulation->present()->articulationCode()}}
                                                        - {{$articulation->present()->articulationName()}}
                                                        @can('update', $articulation)
                                                        <a href="{{route('accompaniments.edit', $articulation)}}"
                                                            class="primary-text pointer tooltipped"
                                                            data-position="right"
                                                            data-tooltip="editar {{__('articulation-stage')}}"><i
                                                                class="tiny material-icons">edit</i></a>
                                                        @endcan
                                                    </span>
                                                    <span class="mailbox-title">{{__('Node')}}
                                                        {{$articulation->articulationstage->present()->articulationStageNode()}}</span>
                                                    <span
                                                        class="mailbox-author">{{$articulation->present()->articulationBy()}}
                                                        (Articulador)</span>
                                                    @if (Route::currentRouteName() == 'articulation-stage.show')
                                                    @can('changeTalent', $articulation)
                                                    <a href="{{ route('articulation-stage.changeinterlocutor', $articulation) }}"
                                                        class="primary-text pointer tooltipped" data-position="right"
                                                        data-tooltip="cambiar {{__('Interlocutory talent')}}"><i
                                                            class="tiny material-icons">edit</i></a>
                                                    @endcan
                                                    @endif
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                                @include('articulation.articulation-history-change')
                                            </div>
                                        </div>
                                        <div class="row">
                                            @canany(['showStart', 'showExecution', 'showClosing', 'changeTalents', 'requestCancel', 'approvalCancel'], $articulation)
                                            <div class="collection with-header col s12 m4 l3">
                                                <h5 href="!#" class="collection-header">Opciones</h5>
                                                @include('articulation.options.articulation-options-menu-left')
                                            </div>
                                            @endcanany
                                        <div class="@canany(['showStart', 'showExecution', 'showClosing', 'changeTalents', 'changePhase', 'requestCancel', 'approvalCancel'], $articulation)col s12 m8 l9 @else col s12 m12 l12  @endcanany">
                                            <div class="row">
                                                <div class="col s12 m12 l4">
                                                    <ul class="collection">
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('Name ArticulationStage')}}
                                                            </span>
                                                            <p>
                                                                {{$articulation->articulationStage->present()->articulationStageCode()}}
                                                                -
                                                                {{$articulation->articulationStage->present()->articulationStageName()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Articulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationCode()}} -
                                                                {{$articulation->present()->articulationName()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('Project')}}
                                                            </span>
                                                            <p>
                                                                {!!
                                                                $articulation->articulationStage->present()->articulationStageableLink()
                                                                !!}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('Start Date')}}
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationStartDate()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Fecha esperada de finalización de la Articulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationExpectedEndDate()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{__('End Date')}}
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationEndDate()}}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col s12 m12 l4">
                                                    <ul class="collection">
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Alcance Articulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationScope()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Objetivo de la articulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationObjetive()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                {{ __('Interlocutory talent') }}
                                                            </span>
                                                            <p>
                                                                {{$articulation->articulationStage->present()->articulationStageInterlocutorTalent()}}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col s12 m12 l4">
                                                    <ul class="collection">
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Entidad con la que se realiza la articulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationEntity()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Nombre de contacto
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationContactName()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Mail institucional de contacto de la organización
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationEmailEntity()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item">
                                                            <span class="title black-text">
                                                                Tipo articulación / tipo subarticulación
                                                            </span>
                                                            <p>
                                                                {{$articulation->present()->articulationSubtype()}}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <div class="wizard clearfix">
                                                    @can('uploadFiles', $articulation)
                                                        @csrf
                                                        {!! method_field('PUT')!!}
                                                        <div>
                                                            @include('articulation.form.cancel-form')
                                                        </div>
                                                    @endcan
                                                    <div class="row">
                                                        @include('articulation.table-archive-phase', ['fase' =>
                                                        'Cancel'])
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
    datatableArchiveArticulationCancel();
    var Dropzone = new Dropzone('#articulation-cancel', {
            url: '{{ route('articulation.files.upload', [$articulation->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "Articulation",
                phase: 'Cancelado'
            },
            paramName: 'nombreArchivo'
        });

    function preguntaCancelar(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de cancelar esta acción de articulación?',
            text: "No podrás revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí!'
        }).then((result) => {
            if (result.value) {
                // document.frmAprobacionProyecto.submit();
            }
        })
    }

    Dropzone.on('success', function (res) {
        $('#archivesArticulationsCancel').dataTable().fnDestroy();
        datatableArchiveArticulationCancel();
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            type: 'success',
            title: 'El archivo se ha subido con éxito!'
        });
    })

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
    })

    Dropzone.autoDiscover = false;

    function datatableArchiveArticulationCancel() {
            $('#archivesArticulationsCancel').DataTable({
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
                        phase: "Cancelado"
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
                    @can('deleteFiles', $articulation)
                    {
                        data: 'delete',
                        name: 'delete',
                        orderable: false,
                    }
                    @endcan
                ],
            });
        }
</script>
@endpush
