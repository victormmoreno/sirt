@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a class="footer-text left-align" href="{{route('proyecto')}}">
                            <i class="material-icons arrow-l left primary-text">arrow_back</i>
                        </a>Proyectos de Base Tecnológica
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{route('proyecto')}}">Proyectos</a></li>
                        <li class="active">Detalle</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card-panel">
                        <div class="card-content container-fluid">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <span class=" mailbox-title title primary-text">{{$proyecto->present()->proyectoNode()}}</span>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <span class="mailbox-title">
                                                    <p class="rigth">
                                                        {{$proyecto->present()->proyectoCode()}} -  {{$proyecto->present()->proyectoName()}}
                                                    </p>
                                                    <br/>
                                                    <p class="right">Linea Tecnológica:
                                                        {{$proyecto->present()->proyectoAbreviaturaLinea()}} - {{$proyecto->present()->proyectoLinea()}}
                                                    </p>
                                                    <br/>
                                                    <small class="right">Fecha de inicio del proyecto:
                                                        {{$proyecto->fecha_inicio}}
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('proyectos.detalles.navegacion')
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('ideas.modals')
@endsection
@push('script')
    <script>
        datatableArchivosDeUnProyecto_inicio();
        datatableArchivosDeUnProyecto_planeacion();
        datatableArchivosDeUnProyecto_ejecucion();
        datatableArchivosDeUnProyecto_cierre();
        datatableArchivosDeUnProyecto_suspendido();

        function datatableArchivosDeUnProyecto_inicio() {
            $('.inicio').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "{{route('proyecto.files', [$proyecto->id, 'Inicio'])}}",
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

        function datatableArchivosDeUnProyecto_planeacion() {
            $('.planeacion').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "{{route('proyecto.files', [$proyecto->id, 'Planeación'])}}",
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

        function datatableArchivosDeUnProyecto_ejecucion() {
            $('.ejecucion').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "{{route('proyecto.files', [$proyecto->id, 'Ejecución'])}}",
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

        function datatableArchivosDeUnProyecto_cierre() {
            $('.cierre').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "{{route('proyecto.files', [$proyecto->id, 'Cierre'])}}",
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

        function datatableArchivosDeUnProyecto_suspendido() {
            $('.Cancelado').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: false,
                ajax: {
                    url: "{{route('proyecto.files', [$proyecto->id, 'Cancelado'])}}",
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
