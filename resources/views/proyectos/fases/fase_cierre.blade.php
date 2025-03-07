@extends('layouts.app')
@section('meta-title', 'Proyectos de Desarrollo Tecnológico')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5 class="primary-text">
                <a class="footer-text left-align" href="{{route('proyecto')}}">
                    <i class="material-icons arrow-l left primary-text">arrow_back</i>
                </a> Proyectos de Base Tecnológica
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('proyectos.titulo')
                            {{-- @include('proyectos.navegacion')
                            @include('proyectos.historial_cambios')
                            @include('proyectos.options.options')
                            @include('proyectos.detalles.detalle_general')
                            @include('proyectos.detalles.detalle_fase_cierre') --}}
                            @include('proyectos.detalles.navegacion')
                            @can('aprobar', $proyecto)
                                @include('proyectos.forms.form_aprobacion')
                            @endcan
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
        datatableArchivosDeUnProyecto_cierre();
    });

    function datatableArchivosDeUnProyecto_cierre() {
        $('#archivosDeUnProyecto').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
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
            @can('delete_files', [$proyecto, $proyecto->IsCierre()])
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
