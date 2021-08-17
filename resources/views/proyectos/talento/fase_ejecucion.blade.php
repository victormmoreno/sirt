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
                @include('proyectos.detalle_fase_ejecucion')
                @if ($ultimo_movimiento->fase == "Ejecución" && $ultimo_movimiento->movimiento == "solicitó al talento" && $proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', 1)->first()->user->id == auth()->user()->id)
                    <form action="{{route('proyecto.aprobacion', [$proyecto->id, 'Ejecución'])}}" method="POST" name="frmEjecucionTalento">
                    {!! method_field('PUT')!!}
                    @csrf
                    <div class="divider"></div>
                    <center>
                        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
                        <input type="hidden" type="text" name="decision" id="decision">
                        <button type="submit" onclick="preguntaEjecucionRechazar(event)" class="waves-effect deep-orange darken-1 btn center-aling">
                        <i class="material-icons right">close</i>
                        No aprobar la fase de ejecución
                        </button>
                        <button type="submit" onclick="preguntaEjecucion(event)" class="waves-effect cyan darken-1 btn center-aling">
                        <i class="material-icons right">done</i>
                        Aprobar fase de ejecución
                        </button>
                        <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
                        <i class="material-icons right">backspace</i>Cancelar
                        </a>
                    </center>
                    </form>
                @else
                    <center>
                        <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
                        <i class="material-icons right">backspace</i>Cancelar
                        </a>
                    </center>
                @endif
                <div class="divider"></div>
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

    function preguntaEjecucion(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de aprobar la fase de ejecución de este proyecto?',
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
                document.frmEjecucionTalento.submit();
                }
        })
    }

    function preguntaEjecucionRechazar(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro(a) de no aprobar la fase de ejecucion de este proyecto?',
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
                document.frmEjecucionTalento.submit();
            }
        })
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
