@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="{{route('proyecto')}}">
                        <i class="material-icons arrow-l left">arrow_back</i>
                    </a> Proyectos de Base Tecnológica
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('proyectos.titulo')
                            @include('proyectos.navegacion')
                            @include('proyectos.historial_cambios')
                            <div class="col offset-m3 offset-l3"></div>
                            @include('proyectos.detalle_general')
                            @include('proyectos.detalle_fase_planeacion')
                            @include('proyectos.form_aprobacion')
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
    $( document ).ready(function() {
        datatableArchivosDeUnProyecto_planeacion();
    });

    function datatableArchivosDeUnProyecto_planeacion() {
        $('#archivosDeUnProyecto').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
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
</script>
@endpush
