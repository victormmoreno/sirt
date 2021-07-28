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
                @include('proyectos.navegacion_fases')
                <div class="divider"></div>
                <br />
                    @include('proyectos.detalle_fase_planeacion')
                    <div class="divider"></div>
                    <center>
                    <a href="{{route('proyecto.inicio', $proyecto->id)}}" class="waves-effect red lighten-2 btn center-aling">
                        <i class="material-icons right">backspace</i>Cancelar
                    </a>
                    </center>
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
    $( document ).ready(function() {
        datatableArchivosDeUnProyecto_planeacion();
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
