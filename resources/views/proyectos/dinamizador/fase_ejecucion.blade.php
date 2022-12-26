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
                        @include('proyectos.titulo')
                        @include('proyectos.navegacion')
                        @include('proyectos.historial_cambios')
                        @include('proyectos.options_always')
                        @include('proyectos.detalle_general')
                        @include('proyectos.detalle_fase_ejecucion')
                        @include('proyectos.form_aprobacion')
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
        datatableArchivosDeUnProyecto_ejecucion();
    });

    function preguntaEjecucion(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Está seguro(a) de aprobar la fase de ejecución de este proyecto?',
        // text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí!'
        }).then((result) => {
        if (result.value) {
            $('#decision').val('aceptado');
            document.frmEjecucionDinamizador.submit();
        }
        })
    }

    function preguntaEjecucionRechazar(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Está seguro(a) de no aprobar la fase de ejecución de este proyecto?',
        input: 'text',
        type: 'warning',
        inputValidator: (value) => {
        if (!value) {
            return 'Las observaciones deben ser obligatorias!'
        } else {
            $('#decision').val('rechazado');
            $('#motivosNoAprueba').val(value);
        }
        },
        inputAttributes: {
        maxlength: 100
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Enviar observaciones!'
        }).then((result) => {
        if (result.value) {
            document.frmEjecucionDinamizador.submit();
        }
        })
    }

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

    function datatableArchivosDeUnProyecto_ejecucion() {
        $('#archivosDeUnProyecto').DataTable({
            language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
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
</script>
@endpush
