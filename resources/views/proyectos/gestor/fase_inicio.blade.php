@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('proyecto')}}">
                <i class="material-icons arrow-l">arrow_back</i>
            </a> Proyectos de Base Tecnológica
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                @include('proyectos.navegacion_fases')
                <div class="row">
                    <div class="col s12 m4 l4 center">
                    <a href="{{route('pdf.proyecto.inicio', $proyecto->id)}}" target="_blank">
                        <div class="card-panel blue white-text">
                        <i class="material-icons left">file_download</i>
                        Descargar formulario.
                        </div>
                    </a>
                    </div>
                    <div class="col s12 m4 l4 center">
                    <a href="{{route('proyecto.entregables.inicio', $proyecto->id)}}">
                        <div class="card-panel blue-grey white-text">
                        <i class="material-icons left">library_books</i>
                        Entregables de la Fase de Inicio.
                        </div>
                    </a>
                    </div>
                    <div class="col s12 m4 l4 center">
                    @if ($proyecto->present()->proyectoFase() == 'Inicio')
                    @if ($ultimo_movimiento == null || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento == App\Models\Movimiento::IsReversar())
                        <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, 'Inicio'])}}">
                        <div class="card-panel yellow accent-1 black-text">
                            Enviar solicitud de aprobación al talento interlocutor.
                        </div>
                        </a>
                    @else
                        @if ($ultimo_movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                        <a disabled>
                            <div class="card-panel yellow accent-1 black-text">
                            Se envió la solicitud de aprobación al talento interlocutor.
                            </div>
                        </a>
                        @endif
                        @if($ultimo_movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->rol == App\User::IsTalento())
                        <a disabled>
                            <div class="card-panel yellow accent-1 black-text">
                            El talento interlocutor aprobó la fase de Inicio, aún falta la aprobación del dinamizador.
                            </div>
                        </a>
                        @endif
                    @endif
                    @else
                    <a disabled>
                        <div class="card-panel yellow accent-1 black-text">
                        Este proyecto no se encuentra en fase de inicio.
                        </div>
                    </a>
                    @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 center">
                    <a href="{{route('pdf.proyecto.acta.inicio', $proyecto->id)}}" target="_blank">
                        <div class="card-panel blue white-text">
                        <i class="material-icons left">file_download</i>
                        Generar acta de inicio de categorización.
                        </div>
                    </a>
                    </div>
                </div>
                <form id="frmProyectos_FaseInicio_Update" action="{{route('proyecto.update.inicio', $proyecto->id)}}" method="POST">
                    {!! method_field('PUT')!!}
                    @include('proyectos.gestor.form_inicio', [
                    'btnText' => 'Modificar'])
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
        @if($proyecto->present()->proyectoFase() == 'Inicio')
            consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#talentosDeTecnoparque_Proyecto_FaseInicio_table', 'add_proyecto');
        @endif

        @if($proyecto->areaconocimiento->nombre == 'Otro')
            divOtroAreaConocmiento.show();
        @endif
        @if($proyecto->present()->isProyectoEconomiaNaranja() == 1)
            divEconomiaNaranja.show();
        @endif
        @if($proyecto->present()->isProyectoDirigidoDiscapacitados()  == 1)
            divDiscapacidad.show();
        @endif
        @if($proyecto->present()->isProyectoActorCTi() == 1)
            divNombreActorCTi.show();
        @endif
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
</script>
@endpush
