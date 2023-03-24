@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo ' . $nodo->entidad->present()->entidadName())
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">domain</i>Tecnoparque
                        Nodo {{ $nodo->entidad->present()->entidadName() }}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('nodo.index') }}">Nodos</a></li>
                        <li class="active">Tecnoparque Nodo {{ $nodo->entidad->present()->entidadName() }}</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <div class="left">
                                                    <span class="mailbox-title primary-text">
                                                        Tecnoparque nodo {{ $nodo->entidad->present()->entidadName() }} -
                                                        {{ $nodo->entidad->present()->entidadLugar() }}
                                                    </span>
                                                    <span class="mailbox-author">
                                                        <b class="secondary-text">Dirección: </b>
                                                        {{ $nodo->direccion }}<br />
                                                        <b class="secondary-text">Correo Electrónco: </b>
                                                        {{ $nodo->entidad->present()->entidadEmail() }}<br />
                                                        <b class="secondary-text">Teléfono: </b>
                                                        {{ isset($nodo->telefono) ? $nodo->telefono : 'No registra' }}<br />
                                                        <b class="secondary-text">Extensión: </b>
                                                        {{ isset($nodo->extension) ? $nodo->extension : 'No registra' }}<br />
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons hide-on-med-and-down">
                                                <span class="mailbox-title">
                                                    <p class="center">Información Tecnoparque Nodo
                                                        {{ $nodo->entidad->present()->entidadName() }}</p><br />
                                                    <p class="center">
                                                        {{ isset($nodo->centro->entidad->nombre) ? $nodo->centro->entidad->nombre : '' }}
                                                        -
                                                        {{ isset($nodo->centro->entidad->ciudad->nombre) ? $nodo->centro->entidad->ciudad->nombre : '' }}
                                                        ({{ isset($nodo->centro->entidad->ciudad->departamento->nombre) ? $nodo->centro->entidad->ciudad->departamento->nombre : '' }})
                                                    </p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="row">
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="card server-card card-transparent">
                                                        <div class="card-content">
                                                            <span
                                                                class="card-title center primary-text m-t-lg">Evidencias</span>
                                                            <div class="row">
                                                                <div class="col s12 m12 l12">
                                                                    <div class="row">
                                                                        <div class="dropzone"
                                                                            id="node_upload_archives"></div>
                                                                    </div>
                                                                    <div class="divider"></div>
                                                                    <table
                                                                        class="display responsive-table datatable-example dataTable"
                                                                        style="width: 100%" id="archives-nodes">
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
    </main>
@endsection
@push('script')
    <script>
        // datatableArchiveArticulationStart();
        var Dropzone = new Dropzone('#node_upload_archives', {
            url: '{{ route('nodo.files.upload', [$nodo->slug]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "Nodo",
                year: "2023"
            },
            paramName: 'file'
        });

        Dropzone.on('success', function (res) {
            $('#archives-nodes').dataTable().fnDestroy();
            // datatableArchiveArticulationStart();
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


    </script>
@endpush
