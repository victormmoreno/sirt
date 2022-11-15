@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align primary-text">
                <h5>
                    <a class="footer-text left-align" href="{{route('proyecto')}}">
                        <i class="material-icons arrow-l left">arrow_back</i>
                    </a> Proyectos de Base Tecnológica
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('proyecto') }}">Proyectos</a></li>
                    <li>
                        <a href="{{route('proyecto.ejecucion', $proyecto)}}">{{ $proyecto->present()->proyectoCode() }}</a>
                    </li>
                    <li class="active">Cierre</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('proyectos.navegacion_fases')
                            <div class="divider"></div><br />
                            @include('proyectos.detalle_fase_cierre')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('script')
    <script>
        $( document ).ready(function() {
        datatableArchivosDeUnProyecto_cierre();
    });
    function changeToPlaneacion() {
        window.location.href = "{{ route('proyecto.planeacion', $proyecto->id) }}";
    }

    function changeToInicio() {
        window.location.href = "{{ route('proyecto.inicio', $proyecto->id) }}";
    }

    function changeToEjecucion() {
        window.location.href = "{{ route('proyecto.ejecucion', $proyecto->id) }}";
    }

    function changeToCierre() {
        window.location.href = "{{ route('proyecto.cierre', $proyecto->id) }}";
    }

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
        ],
    });
    }
</script>
@endpush
