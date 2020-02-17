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
          </a> Proyectos
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="row">
                <div class="col s12 m6 l6 center">
                    <a class="btn-large blue m-b-xs" href="{{route('pdf.proyecto.incio', $proyecto->id)}}" target="_blank">
                        <i class="material-icons left">file_download</i>
                        Descargar formulario.
                    </a>
                </div>
                <div class="col s12 m6 l6 center">
                    <a class="btn-large blue-grey m-b-xs" href="{{route('proyecto.entregables.inicio', $proyecto->id)}}">
                        <i class="material-icons left">library_books</i>
                        Entregables de la Fase de Inicio.
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
    @if($proyecto->fase->nombre == 'Inicio')
    consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#talentosDeTecnoparque_Proyecto_FaseInicio_table', 'add_proyecto');
    @endif
    
  @if($proyecto->areaconocimiento->nombre == 'Otro')
    divOtroAreaConocmiento.show();
  @endif
  @if($proyecto->economia_naranja == 1)
  divEconomiaNaranja.show();
  @endif
  @if($proyecto->dirigido_discapacitados == 1)
  divDiscapacidad.show();
  @endif
  @if($proyecto->art_cti == 1)
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