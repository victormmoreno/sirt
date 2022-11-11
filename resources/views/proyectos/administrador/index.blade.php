@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">library_books</i>Proyectos de Base Tecnológica
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Proyectos</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="center-align">
                                        <span class="card-title center-align primary-text">Proyectos de Tecnoparque</span>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                                                <li class="tab col s3"><a href="#proyectos_por_nodo"
                                                        class="active">Proyectos Por Nodo</a></li>
                                                <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                                            </ul>
                                            <br>
                                        </div>
                                    </div>
                                    <div id="proyectos_por_nodo">
                                        <div class="row">
                                            <div class="col s12 m6 l6">
                                                <div class="input-field col s12 m12 l12">
                                                    <select class="js-states" tabindex="-1" style="width: 100%"
                                                        id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho"
                                                        onchange="consultarProyectosDelNodoPorAnho();">
                                                        {!! $year = Carbon\Carbon::now();
                                                        $year = $year->isoFormat('YYYY') !!}
                                                        @for ($i = 2016; $i <= $year; $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
                                                </div>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <select class="js-states" name="nodo_proyectoPorNodoYAnho"
                                                    id="nodo_proyectoPorNodoYAnho" style="width: 100%">
                                                    @foreach ($nodos as $nodo)
                                                        <option value="{{ $nodo->id }}">{{ $nodo->nodos }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="nodo_proyectoPorNodoYAnho">Seleccione el Nodo</label>
                                            </div>
                                        </div>

                                        <div class="row center">
                                            <div class="col s12 m4 l4 offset-l4">
                                                <a onclick="consultarProyectosDelNodoPorAnho_Administrador();"
                                                    href="javascript:void(0)">
                                                    <div class="card bg-secondary">
                                                        <div class="card-content center flow-text">
                                                            <i class="left material-icons white-text small">search</i>
                                                            <span class="white-text">Consultar Proyectos</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @include('proyectos.table')
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
    @include('proyectos.modals')
@endsection
@push('script')
    <script>
        $("#codigo_proyecto_tblproyectosDelNodoPorAnho_Administrador").keyup(function() {
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable().draw();
        });

        $("#gestor_tblproyectosDelNodoPorAnho_Administrador").keyup(function() {
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable().draw();
        });

        $("#nombre_tblproyectosDelNodoPorAnho_Administrador").keyup(function() {
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable().draw();
        });

        $("#sublinea_nombre_tblproyectosDelNodoPorAnho_Administrador").keyup(function() {
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable().draw();
        });

        $("#estado_nombre_tblproyectosDelNodoPorAnho_Administrador").keyup(function() {
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable().draw();
        });

        /**
         * Consulta los proyectos de un nodo por año (Este método es para el dinamizador)
         */
        function consultarProyectosDelNodoPorAnho_Administrador() {
            let anho_proyectos_nodo = $('#anho_proyectoPorNodoYAnho').val();
            let nodo = $('#nodo_proyectoPorNodoYAnho').val();
            $('#tblproyectosDelNodoPorAnho_Administrador').dataTable().fnDestroy();
            $('#tblproyectosDelNodoPorAnho_Administrador').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                order: [0, 'desc'],
                "lengthChange": false,
                ajax: {
                    url: host_url + "/proyecto/datatableProyectosDelNodoPorAnho/" + nodo + "/" +
                        anho_proyectos_nodo,
                    data: function(d) {
                        d.codigo_proyecto = $('#codigo_proyecto_tblproyectosDelNodoPorAnho_Administrador')
                        .val(),
                            d.gestor = $('#gestor_tblproyectosDelNodoPorAnho_Administrador').val(),
                            d.nombre = $('#nombre_tblproyectosDelNodoPorAnho_Administrador').val(),
                            d.sublinea_nombre = $('#sublinea_nombre_tblproyectosDelNodoPorAnho_Administrador')
                            .val(),
                            d.estado_nombre = $('#estado_nombre_tblproyectosDelNodoPorAnho_Administrador')
                        .val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        width: '15%',
                        data: 'codigo_proyecto',
                        name: 'codigo_proyecto',
                    },
                    {
                        data: 'gestor',
                        name: 'gestor',
                    },
                    {
                        data: 'nombre',
                        name: 'nombre',
                    },
                    {
                        data: 'sublinea_nombre',
                        name: 'sublinea_nombre',
                    },
                    {
                        data: 'nombre_fase',
                        name: 'nombre_fase',
                    },
                    {
                        width: '8%',
                        data: 'info',
                        name: 'info',
                        orderable: false
                    },
                    {
                        width: '8%',
                        data: 'proceso',
                        name: 'proceso',
                        orderable: false
                    },
                ],
            });
        }
    </script>
@endpush
