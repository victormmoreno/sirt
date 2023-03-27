@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo ' . $nodo->entidad->present()->entidadName())
@section('content')
    @php
        $year = Carbon\Carbon::now()->year;
    @endphp
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
                        <li><a href="{{route('nodo.show', $nodo->entidad->slug)}}">Tecnoparque Nodo {{$nodo->entidad->present()->entidadName()}}</a></li>
                        <li class="active">Archivos</li>
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
                                                                class="card-title center primary-text m-t-lg">Archivos</span>
                                                            <div class="row">
                                                                <div class="col s12 m12 l12">
                                                                    <div class="row">
                                                                        <div class="dropzone"
                                                                            id="node_upload_archives"></div>
                                                                    </div>
                                                                    <div class="divider"></div>
                                                                    <div class="row">
                                                                        <div class="input-field col s12 m3 l3">
                                                                            <label class="active" for="filter_year_archive_node">Año <span class="red-text">*</span></label>
                                                                            <select tabindex="-1" style="width: 100%"  name="filter_year_file_node" id="filter_year_file_node">
                                                                                @for ($i=$year; $i >= 2022; $i--)
                                                                                    <option @if($i==$year) selected @endif value="{{$i}}" >{{$i}}</option>
                                                                                @endfor
                                                                                <option value="all" >todos</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col s12 m6 l5 offset-m3 right">
                                                                            <button class="waves-effect  waves-grey bg-secondary white-text btn-flat search-tabs-button right" id="filter_file_node"><i class="material-icons">search</i>{{__('Filter')}}</button>
                                                                        </div>
                                                                    </div>
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
        $(document).ready(function() {
        let filter_year_file_node = $('#filter_year_file_node').val();
        if( (filter_year_file_node =='' || filter_year_file_node == null)){
            datatableArchiveNode(filter_year_file_node = null);
        }else if(filter_year_file_node !=''){
            datatableArchiveNode(filter_year_file_node);
        }else{
            $('#archives-nodes').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "pageLength": 10,
                "lengthChange": false,
            }).clear().draw();
            }
        });

    $('#filter_file_node').click(function () {

        let filter_year_file_node = $('#filter_year_file_node').val();
        $('#archives-nodes').dataTable().fnDestroy();
        if((filter_year_file_node == '' || filter_year_file_node == null)){
            datatableArchiveNode(filter_year_file_node = null);
        }else if((filter_year_file_node != '' || filter_year_file_node != null)){
            datatableArchiveNode(filter_year_file_node);
        }else{
            $('#archives-nodes').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "pageLength": 10,
                "lengthChange": false,
            }).clear().draw();
        }
    });

        var Dropzone = new Dropzone('#node_upload_archives', {
            url: '{{ route('nodo.files.upload', [$nodo->entidad->slug]) }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra los archivos aquí para subirlos.',
            params: {
                type: "Nodo",
                year: '{{ $year }}'
            },
            paramName: 'nombreArchivo'
        });

        Dropzone.on('success', function (res) {
            $('#archives-nodes').dataTable().fnDestroy();
            datatableArchiveNode();
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

        function datatableArchiveNode(filter_year){
            $('#archives-nodes').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar Entradas _MENU_",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                lengthMenu: [
                    [5, 10, 25,50, 100, -1],
                    [5, 10,25, 50, 100, 'Todos'],
                ],
                "pageLength": 10,
                "lengthChange": false,
                processing: false,
                serverSide: false,
                order: false,
                ajax:{
                    url: "{{route('nodo.files', [$nodo->entidad->slug])}}",
                    type: "get",
                    data: {
                        type: "Nodo",
                        year: filter_year
                        // filter_year_file: filter_year,
                    }
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
                ]
            });
        }
    </script>
@endpush
