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
                        
                        <form action="{{route('proyecto.aprobacion', [$proyecto->id, 'Inicio'])}}" method="POST" name="frmInicioTalento">
                        {!! method_field('PUT')!!}
                        @csrf
                        <div class="divider"></div>
                        <center>
                            <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
                            <input type="hidden" type="text" name="decision" id="decision">
                            <button type="submit" onclick="preguntaInicioRechazar(event)" class="waves-effect deep-orange darken-1 btn center-aling">
                            <i class="material-icons right">close</i>
                            No aprobar la fase de Inicio
                            </button>
                            <button type="submit" onclick="preguntaInicio(event)" class="waves-effect cyan darken-1 btn center-aling">
                            <i class="material-icons right">done</i>
                            Aprobar fase de inicio
                            </button>
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
        @if($proyecto->areaconocimiento->nombre == 'Otro')
            divOtroAreaConocmiento.show();
        @endif
        @if($proyecto->present()->isProyectoEconomiaNaranja() == 1)
            divEconomiaNaranja.show();
        @endif
        @if($proyecto->present()->isProyectoDirigidoDiscapacitados() == 1)
            divDiscapacidad.show();
        @endif
        @if($proyecto->present()->isProyectoActorCTi() == 1)
            divNombreActorCTi.show();
        @endif
        datatableArchivosDeUnProyecto_inicio();
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

    function preguntaInicioRechazar(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de no aprobar la fase de inicio de este proyecto?',
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
            maxlength: 100,
            placeHolder: '¿Por qué?'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Enviar observaciones!'
        }).then((result) => {
            if (result.value) {
                document.frmInicioTalento.submit();
            }
        })
    }

    function preguntaInicio(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de aprobar la fase de inicio de este proyecto?',
            text: 'Al hacerlo estás aceptando y aprobando toda la información de esta fase, los documento adjuntos y las asesorias recibidas.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí!'
        }).then((result) => {
            if (result.value) {
                $('#decision').val('aceptado');
                document.frmInicioTalento.submit();
            }
        })
    }
</script>
@endpush
