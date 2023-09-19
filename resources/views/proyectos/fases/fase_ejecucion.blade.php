@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
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
                    @include('proyectos.navegacion')
                    @include('proyectos.historial_cambios')
                    @include('proyectos.options.options')
                    @include('proyectos.detalles.detalle_general')
                    @include('proyectos.detalles.prorrogas')
                    @include('proyectos.detalles.detalle_fase_ejecucion')
                    @can('aprobar', $proyecto)
                        @include('proyectos.forms.form_aprobacion')
                    @endcan
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
        datatableArchivosDeUnProyecto_ejecucion();
        @can('solicitar_fecha', $proyecto)
            pedirFechaDeEjecucion(event);
        @endcan
    });

    function pedirFechaDeEjecucion() {
        Swal.fire({
            title: 'Se necesita una fecha estimada para la terminar la ejecución del proyecto',
            html: 'Para continuar se necesita ingresar la fecha de finalización de ejecución del proyecto según el <b>cronograma</b> adjuntado en esta fase. En el formato YYYY-MM-DD',
            type: 'warning',
            input: 'text',
            footer: '<a href="{{route('proyecto.planeacion', $proyecto->id)}}" target="_blank">Ir a las evidencias de la fase de planeación</a>',
            inputValidator: ( value ) => {
                let date = new Date(value);
                let today = new Date();
                if (!value) {
                    return 'La fecha para terminar la ejecución es obligatoria';
                }
                if (!isDateValid(value)) {
                    return 'El formato de fecha debe ser (YYYY-MM-DD)';
                }
                if (value.length < 10) {
                    return 'Formato inválido de fecha';
                }
                if (date < today) {
                    return 'Ingrese una fecha posterior al día de hoy';
                }
            },
            inputAttributes: {
                maxlength: 10,
                // min: 10,
                placeHolder: 'Fecha (YYYY-MM-DD)'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Guardar!'
        }).then((result) => {
            let route = "/proyecto/registrar_fecha/"+{{$proyecto->id}}+'/'+result.value;
            if (result.value) {
                // let route = '/proyecto/registrar_fecha/'+{{$proyecto->id}}+'/'+result.value;

                location.href=route;
            }
        });
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
            @can('delete_files', [$proyecto, $proyecto->IsEjecucion()])
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
