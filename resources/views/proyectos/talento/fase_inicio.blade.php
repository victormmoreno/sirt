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
                        @include('proyectos.detalle_fase_inicio')
                        <form action="{{route('proyecto.aprobacion', [$proyecto->id])}}" method="POST" name="frmAprobacionProyecto">
                        {!! method_field('PUT')!!}
                        @csrf
                        <div class="divider"></div>
                        <center>
                            @include('proyectos.botones_aprobacion_component')
                            <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
                            <i class="material-icons right">backspace</i>Cancelar
                            </a>
                        </center>
                        </form>
                        
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
        datatableArchivosDeUnProyecto_inicio();
    });


    function datatableArchivosDeUnProyecto_inicio() {
        $('#archivosDeUnProyecto').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
            serverSide: true,
            order: false,
            ajax:{
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

    // function preguntaRechazarAprobacionProyecto(e){
    //     e.preventDefault();
    //     Swal.fire({
    //         title: '¿Está seguro(a) de no aprobar la fase de inicio de este proyecto?',
    //         input: 'text',
    //         type: 'warning',
    //         inputValidator: (value) => {
    //             if (!value) {
    //                 return 'Las observaciones deben ser obligatorias!'
    //             } else {
    //                 $('#decision').val('rechazado');
    //                 $('#motivosNoAprueba').val(value);
    //             }
    //         },
    //         inputAttributes: {
    //         maxlength: 100,
    //         placeHolder: '¿Por qué?'
    //         },
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         cancelButtonText: 'Cancelar',
    //         confirmButtonText: 'Enviar observaciones!'
    //     }).then((result) => {
    //         if (result.value) {
    //             document.frmAprobacionTalento.submit();
    //         }
    //     })
    // }

    // function preguntaAprobacion(e){
    //     e.preventDefault();
    //     Swal.fire({
    //         title: '¿Está seguro(a) de aprobar la fase de inicio de este proyecto?',
    //         text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase, los documento adjuntos y las asesorias recibidas.',
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         cancelButtonText: 'Cancelar',
    //         confirmButtonText: 'Sí!'
    //     }).then((result) => {
    //         if (result.value) {
    //             $('#decision').val('aceptado');
    //             document.frmAprobacionTalento.submit();
    //         }
    //     })
    // }
</script>
@endpush
