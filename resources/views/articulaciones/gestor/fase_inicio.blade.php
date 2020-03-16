@extends('layouts.app')
@section('meta-title', 'Articulaciones G.I')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('articulacion')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Articulaciones con Grupos de Investigación
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('articulaciones.navegacion_fases')
              <div class="row">
                <div class="col s12 m4 l4 center">
                  <a href="{{route('pdf.articulacion.inicio', $articulacion->id)}}" target="_blank">
                    <div class="card-panel blue white-text">
                      <i class="material-icons left">file_download</i>
                      Descargar formulario.
                    </div>
                  </a>
                </div>
                <div class="col s12 m4 l4 center">
                  <a href="{{route('articulacion.entregables.inicio', $articulacion->id)}}">
                    <div class="card-panel blue-grey white-text">
                      <i class="material-icons left">library_books</i>
                      Entregables de la Fase de Inicio.
                    </div>
                  </a>
                </div>
                <div class="col s12 m4 l4 center">
                  @if ($articulacion->fase->nombre == 'Inicio')
                  <a href="{{route('articulacion.notificar.inicio', $articulacion->id)}}">
                    <div class="card-panel yellow accent-1 black-text">
                      Solicitar al dinamizador que apruebe la fase de inicio.
                    </div>
                  </a>
                  @else
                  <a disabled>
                    <div class="card-panel yellow accent-1 black-text">
                      Esta fase ya ha sido aprobada por el dinamizador.
                    </div>
                  </a>
                  @endif
                </div>
              </div>
              <form id="frmArticulaciones_FaseInicio_Update" action="{{route('articulacion.update.inicio', $articulacion->id)}}" method="POST">
                {!! method_field('PUT')!!}
                @include('articulaciones.gestor.form_inicio', [
                'btnText' => 'Modificar'])
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>
@endsection
@include('articulaciones.modals')
@push('script')
<script>
  $( document ).ready(function() {
    consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table('#talentosDeTecnoparque_Articulacion_FaseInicio_table', 'add_articulacion');
  });

  function changeToInicio() {
    window.location.href = "{{ route('articulacion.inicio', $articulacion->id) }}";
  }

  function changeToPlaneacion() {
    window.location.href = "{{ route('articulacion.planeacion', $articulacion->id) }}";
  }

  function changeToEjecucion() {
    window.location.href = "{{ route('articulacion.ejecucion', $articulacion->id) }}";
  }

  function changeToCierre() {
    window.location.href = "{{ route('articulacion.cierre', $articulacion->id) }}";
  }

</script>
@endpush