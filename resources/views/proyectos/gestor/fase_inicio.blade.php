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
                  @if ( ($proyecto->fase->nombre == 'Inicio' && $ultimo_movimiento == null) || 
                  ($proyecto->fase->nombre == 'Inicio' && $ultimo_movimiento->movimiento == App\Models\Movimiento::IsCambiar()) ||
                  ($ultimo_movimiento->rol == App\User::IsTalento() && $ultimo_movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() && $ultimo_movimiento->fase == 'Inicio' ) || 
                  ($ultimo_movimiento->rol == App\User::IsDinamizador() && $ultimo_movimiento->movimiento == App\Models\Movimiento::IsNoAprobar() && $ultimo_movimiento->fase == 'Inicio' ) ||
                  ($ultimo_movimiento->rol == App\User::IsDinamizador() && $ultimo_movimiento->movimiento == App\Models\Movimiento::IsReversar()) )
                  <a href="{{route('proyecto.solicitar.aprobacion', [$proyecto->id, 'Inicio'])}}">
                    <div class="card-panel yellow accent-1 black-text">
                      Solicitar al talento interlocutor que apruebe la fase de inicio.
                    </div>
                  </a>
                  @else
                  <a disabled>
                    <div class="card-panel yellow accent-1 black-text">
                      Esta fase ya ha sido aprobada por el talento y/o dinamizador (Para mas detalle ver el historial de movimientos).
                    </div>
                  </a>
                  @endif
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