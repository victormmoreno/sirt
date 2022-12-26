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
                    <form id="frmProyectos_FaseInicio_Update" action="{{route('proyecto.update.inicio', $proyecto->id)}}" method="POST">
                        {!! method_field('PUT')!!}
                        @include('proyectos.gestor.forms.form_inicio', [
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

</script>
@endpush
