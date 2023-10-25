@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
    @php
        $year = Carbon\Carbon::now()->year;
    @endphp
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
                        <li><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                        <li>
                            <a href="{{route('articulation-stage.show',  $articulation->articulationstage)}}">{{ $articulation->articulationstage->present()->articulationStageCode() }}</a>
                        </li>
                        <li>
                            <a href="{{route('articulations.show',  $articulation)}}">{{ $articulation->present()->articulationCode() }}</a>
                        </li>
                        <li class="active">Cierre</li>
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
                                            <li class="text-mailbox ">La articulación se encuentra actualmente en la
                                                fase de {{$articulation->present()->articulationPhase()}}</li>
                                            <div class="right">
                                                <li class="text-mailbox">Fecha
                                                    Inicio: {{$articulation->present()->articulationStartDate()}}</li>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="mailbox-view no-s">
                                        <div class="mailbox-view-header">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <span class="mailbox-title">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}
                                                            @can('update', $articulation)
                                                                <a href="{{route('accompaniments.edit', $articulation)}}"
                                                                   class="primary-text text-darken-2 pointer tooltipped"
                                                                   data-position="right"
                                                                   data-tooltip="editar {{__('articulation-stage')}}"><i
                                                                        class="tiny material-icons">edit</i></a>
                                                            @endcan
                                                        </span>
                                                        <span
                                                            class="mailbox-title">{{__('Node')}} {{$articulation->articulationstage->present()->articulationStageNode()}}</span>
                                                        <span class="mailbox-author">{{$articulation->present()->articulationBy()}} (Articulador)</span>
                                                        @if (Route::currentRouteName() == 'articulation-stage.show')
                                                            @can('changeTalent', $articulation)
                                                                <a href="{{ route('articulation-stage.changeinterlocutor', $articulation) }}"
                                                                   class="primary-text text-darken-2 pointer tooltipped"
                                                                   data-position="right"
                                                                   data-tooltip="cambiar {{__('Interlocutory talent')}}"><i
                                                                        class="tiny material-icons">edit</i></a>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <form id="articulation-form-closing"
                                                action="{{route('articulation.update.closing', $articulation)}}" method="POST">
                                            {!! method_field('PUT')!!}
                                            <div class="wizard clearfix">
                                                @include('articulation.form.closing-form', ['btnText' => 'Modificar'])
                                                <div class="actions clearfix right-align">
                                                    <ul role="menu" aria-label="Paginación">
                                                        <li aria-hidden="false" aria-disabled="false">
                                                            <a href="{{route('articulations.show', $articulation)}}"
                                                                role="menuitem"
                                                                class="waves-effect waves-blue btn-flat primary-text">Volver
                                                                atrás</a>
                                                        </li>
                                                        <li class="disabled" aria-disabled="true">
                                                            <button type="submit" role="menuitem"
                                                                    class="btn waves-effect waves-blue btn-flat primary-text">
                                                                Guardar
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
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
        $(document).ready(function () {
            datatableArchiveArticulation();
            articulationClosing.checkedTypePostulacion();
            articulationClosing.checkedApproval();
        });

        let articulationClosing = {
            checkedTypePostulacion: function () {
                let postulation = $('input:radio[name=postulation]:checked').val();
                console.log(postulation);
                if (postulation == "yes") {
                    $(".r-si").show();
                    $(".r-no").hide();
                } else if (postulation == "no") {
                    $(".r-no").show();
                    $(".r-si").hide();
                } else {
                    $(".r-si").show();
                    $(".r-no").hide();
                }
            },
            checkedApproval: function () {
                let approval = $('input:radio[name=approval]:checked').val();

                if (approval == "aprobado") {
                    $(".r-aprobado").show();
                    $(".r-no-aprobado").hide();
                } else if (approval == "noaprobado") {
                    $(".r-no-aprobado").show();
                    $(".r-aprobado").hide();
                } else {
                    $(".r-aprobado").show();
                    $(".r-no-aprobado").hide();
                }
            },
        }

        var Dropzone = new Dropzone('#articulation-closing-phase', {
            url: '{{ route('articulation.files.upload', [$articulation->id]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "Articulation",
                phase: 'Cierre'
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            $('#archivesArticulationsClosing').dataTable().fnDestroy();
            datatableArchiveArticulation();
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
            let msg = res.errors.nombreArchivo[0];
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

        function datatableArchiveArticulation() {
            $('#archivesArticulationsClosing').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                "ajax": {
                    "url": "{{route('articulation.files', [$articulation->id])}}",
                    "type": "get",
                    "data": {
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

